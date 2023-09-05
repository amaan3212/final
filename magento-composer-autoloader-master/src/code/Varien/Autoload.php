<?php

/**
 * Be aware that this file may cause conflicts when upgrading to newer Magento versions.
 * It should be simple to fix if Magento makes any changes to the Autoloader however.
 *
 * This is mostly a C+P of Magento Autoloader, with Composer addition
 *
 * Classes source autoload
 *
 * @author Aydin Hassan <aydin@wearejh.com>
 */
class Varien_Autoload
{
    const SCOPE_FILE_PREFIX = '__';

    static protected $_instance;
    static protected $_scope = 'default';

    protected $_isIncludePathDefined= null;
    protected $_collectClasses      = false;
    protected $_collectPath         = null;
    protected $_arrLoadedClasses    = array();

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->bootstrapComposer();
        $this->_isIncludePathDefined = defined('COMPILER_INCLUDE_PATH');
        if (defined('COMPILER_COLLECT_PATH')) {
            $this->_collectClasses  = true;
            $this->_collectPath     = COMPILER_COLLECT_PATH;
        }
        self::registerScope(self::$_scope);
    }

    /**
     * Determine basedir and include composer autoloader
     *
     * Assumes composer libraries are installed in a directory called 'vendor'
     * which exists in the magento basedir. OR - One directory up, so if Magento is
     * installed in ./htdocs in project root
     *
     */
    protected function bootstrapComposer()
    {
        $bp = $this->basePath();

        //directories where Composer Vendor dir may be
        $possibleDirectories = array(
            sprintf('%s/vendor', $bp),      //magento root
            sprintf('%s/../vendor', $bp),   //up one dir
        );

        //loop possible directories and require the first autload.php that it found, break after
        foreach ($possibleDirectories as $dir) {
            $autoloader = $dir . '/autoload.php';
            if (is_readable($autoloader)) {
                require_once $autoloader;
                //break on successful require
                break;
            }
        }
    }

    /**
     * @return string
     */
    protected function basePath()
    {
        $ds = DIRECTORY_SEPARATOR;

        if (defined('BP')) {
            return BP;

        } else {
            $upOneDir = $ds . '..';
            return realpath(dirname(__FILE__) 
                . $upOneDir 
                . $upOneDir
                . $upOneDir
                . $upOneDir
                . $ds
            );
        }
    }

    /**
     * Singleton pattern implementation
     *
     * @return Varien_Autoload
     */
    static public function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Varien_Autoload();
        }
        return self::$_instance;
    }

    /**
     * Register SPL autoload function
     */
    static public function register()
    {
        spl_autoload_register(array(self::instance(), 'autoload'));
    }

    /**
     * Load class source code
     *
     * @param string $class
     */
    public function autoload($class)
    {
        if ($this->_collectClasses) {
            $this->_arrLoadedClasses[self::$_scope][] = $class;
        }
        if ($this->_isIncludePathDefined) {
            $classFile =  COMPILER_INCLUDE_PATH . DIRECTORY_SEPARATOR . $class;
        } else {
            $classFile = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $class)));
        }
        $classFile.= '.php';
        //echo $classFile;die();
        return include $classFile;
    }

    /**
     * Register autoload scope
     * This process allow include scope file which can contain classes
     * definition which are used for this scope
     *
     * @param string $code scope code
     */
    static public function registerScope($code)
    {
        self::$_scope = $code;
        if (defined('COMPILER_INCLUDE_PATH')) {
            @include COMPILER_INCLUDE_PATH . DIRECTORY_SEPARATOR . self::SCOPE_FILE_PREFIX.$code.'.php';
        }
    }

    /**
     * Get current autoload scope
     *
     * @return string
     */
    static public function getScope()
    {
        return self::$_scope;
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        if ($this->_collectClasses) {
            $this->_saveCollectedStat();
        }
    }

    /**
     * Save information about used classes per scope with class popularity
     * Class_Name:popularity
     *
     * @return Varien_Autoload
     */
    protected function _saveCollectedStat()
    {
        if (!is_dir($this->_collectPath)) {
            @mkdir($this->_collectPath);
            @chmod($this->_collectPath, 0777);
        }

        if (!is_writeable($this->_collectPath)) {
            return $this;
        }

        foreach ($this->_arrLoadedClasses as $scope => $classes) {
            $file = $this->_collectPath.DIRECTORY_SEPARATOR.$scope.'.csv';
            $data = array();
            if (file_exists($file)) {
                $data = explode("\n", file_get_contents($file));
                foreach ($data as $index => $class) {
                    $class = explode(':', $class);
                    $searchIndex = array_search($class[0], $classes);
                    if ($searchIndex !== false) {
                        $class[1]+=1;
                        unset($classes[$searchIndex]);
                    }
                    $data[$index] = $class[0].':'.$class[1];
                }
            }
            foreach ($classes as $class) {
                $data[] = $class . ':1';
            }
            file_put_contents($file, implode("\n", $data));
        }
        return $this;
    }
}
