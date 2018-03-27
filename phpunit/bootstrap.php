<?php
error_reporting(E_ALL|E_STRICT);

if(is_file("vendor/autoload.php"))
{
	require_once("vendor/autoload.php");
	//spl_autoload_register(function($classname){
	//	$classname = str_replace("_", "\\", $classname);
	//	echo $classname;
	//});
}

/**
 * Often XDebug is NOT necessary.
 * @see https://xdebug.org/docs/all_functions
 */
$xdebug_disable = "xdebug_disable";
if(function_exists($xdebug_disable)) {
	$xdebug_disable();
}
