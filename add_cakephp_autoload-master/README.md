# How to add Cakephp autoload from vendor to boostrap.php
I made this tutorial for Cakephp 2 or 3. 
This is a little magic that will add Vendor autoload or let me say include the composer autoload to your project boostrap.php file

`if (file_exists(APP . DS . 'Vendor' . DS . 'autoload.php')) {
	require_once APP . DS . 'Vendor' . DS . 'autoload.php';
	spl_autoload_unregister(array('App', 'load'));
	spl_autoload_register(array('App', 'load'), true, true);
} else {
	die('Composer install has not yet been run.');
}`

