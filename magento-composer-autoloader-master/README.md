# Magento Composer Autoloader #

A module to overwrite Magento's autoloader to include a step to require Composer's auto loader so we can fully embrace the wonderful world of Open source! Now we can use awesome libraries like [Gaufrette](https://github.com/KnpLabs/Gaufrette). Inspired by [this](https://github.com/ajbonner/magento-composer-autoload) and modified to look in Magento root dir or one directory up in case magento is installed in ./htdocs or something similar.

## Using a library

### Install Magento Composer Autoloader

Require this project in your Magento build. If you have used the [Magento Skeleton](https://bitbucket.org/jhhello/jh_magento_skeleton/src) then you can omit this step as it it already included.

```shell
$ cd project-root
$ composer require "jhhello/magento_composer_autoloader"
```

When asked for a version, specify "1.0.0" or the latest tag of the project.

After the autoloader patcher has been installed you can start adding external projects. We will use [Gaufrette](v) as an example. 


### Install Required Library

```shell
$ cd project-root
$ composer require knplabs/gaufrette
```

When asked for a version specify: "*" or the specific version you want.

### Use it!

In a model somewhere (before class declaration):

```php
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
```

In a function somewhere:

```php
$adapter 		= new LocalAdapter('/var/media');
$filesystem 	= new Filesystem($adapter);

$filesystem->write('jim.txt', 'Come on baby light my fire');
```