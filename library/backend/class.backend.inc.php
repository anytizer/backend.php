<?php
namespace backend;

/**
 * Define the class repositories.
 * Array of $locations is the possible locations where we may find the class body.
 * @uses __TEMP_PATH__
 */
class backend
{
	private $log_access = false;
	private $log_file = '/tmp/classes.log';

	public function __construct()
	{
	}
	
	/**
	 * Detemine to write log file for classes accessed
	 */
	public function log_access($log_access = false, $log_file='/tmp/classes.log')
	{
		$this->log_access = $log_access===true;
		$this->log_file = __TEMP_PATH__.'/classes.log';
	}
	
	public function setup()
	{
		spl_autoload_register(array($this, '_search_and_include_class_files'), true, false);
	}

	public function _search_and_include_class_files($class_name = "")
	{
		#echo "\r\nSearching for Autoloaded Class: {$class_name}";
		$namespaces = explode('\\', $class_name);
		#print_r($namespaces);
		$class_name = $namespaces[count($namespaces)-1];
		#$class_name = preg_replace('/^.*?\/[a-z0-9]{1,}$/', '$1', $class_name);
		#echo "\r\nNew name: {$class_name}";

		# Sanitize the class name by removing unnecessary/invalid characters
		$class_name = preg_replace('/[^a-z0-9\_]+/', '_', strtolower($class_name));

		$locations = array();

		# Attempt to load from known __SUBDOMAIN_BASE__ if available
		if(defined('__SUBDOMAIN_BASE__') && is_dir(constant('__SUBDOMAIN_BASE__')))
		{
			$locations[] = constant('__SUBDOMAIN_BASE__') . "/classes/class.{$class_name}.inc.php";
		}
		
		/**
		 * @todo Make the list dynamic
		 */

		# Subdomain's own class files in an expected area. __SUBDOMAIN_BASE__ is still unknown.
		# $locations[] = __LIBRARY_PATH__ . "/{$_SERVER['SERVER_NAME']}/classes/class.{$class_name}.inc.php";

		# List of standard data types, interfaces and abstract classes
		$locations[] = __LIBRARY_PATH__ . "/interfaces/interface.{$class_name}.inc.php";

		# Abstract Classes
		$locations[] = __LIBRARY_PATH__ . "/abstracts/abstract.{$class_name}.inc.php";

		# Generally useful classes
		$locations[] = __LIBRARY_PATH__ . "/common/class.{$class_name}.inc.php";

		# Specific to this framework - calling from sub projects
		$locations[] = __LIBRARY_PATH__ . "/backend/class.{$class_name}.inc.php";
		$locations[] = __LIBRARY_PATH__ . "/images/class.{$class_name}.inc.php";

		# Low priority loading or unclassified files
		$locations[] = __LIBRARY_PATH__ . "/others/class.{$class_name}.inc.php";

		# Third party class files (original or in modified forms)
		$locations[] = __LIBRARY_PATH__ . "/third/class.{$class_name}.inc.php";

		# Parent (Framework)'s main class files
		# $locations[] = __SUBDOMAIN_BASE__ . "/class.{$class_name}.inc.php";

		# In the same directory
		$locations[] = "class.{$class_name}.inc.php";
		#print_r($locations);

		$locations = array_filter(array_map('realpath', $locations));
		#print_r($locations);

		/**
		 * Was the class file found and included successfully?
		 */
		$included = false;

		foreach($locations as $l => $class_file)
		{
			if(is_file($class_file))
			{
				require_once($class_file);
				$included = true;
				
				if($this->log_access)
				{
					file_put_contents($this->log_file, "\r\n{$class_name}: {$class_file}", FILE_APPEND);
				}

				break;
			}
		}

		return $included;
	} # __search_and_include_classes()
}