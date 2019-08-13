<?php

/**
 * Auto Loading /src/*
 */

/*spl_autoload_register(function($class){
	$classPath = str_replace('\\', '/', $class);
	include __DIR__ . '/src/' . $classPath . '.php';
});*/

/**
 * Loading System
 */
require_once 'configs.php';
require_once 'system/routes.php';

?>
