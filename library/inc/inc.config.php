<?php
/**
 * Pre-load public_html/inc.bootstrap.php
 */
if(empty($backend) || empty($backend['signatures']['paths']))
{
	/**
	 * @todo Verify with Hash Key: c7676247d2f8ccf713a61e7dddd8dfda
	 */
	die("Configurations not yet loaded: public_html/inc.bootstrap.php.");
	
}
foreach($backend['paths'] as $p => $path)
{
	if(!is_dir($path))
	{
		throw new \Exception("{$p}: {$path} - not valid directory.");
	}
}

$umask = umask(0);

/**
 * Validate necessary server variables
 * @todo Use PHP7 Null Coalesce Operator https://wiki.php.net/rfc/isset_ternary
 */
$_SERVER['HTTP_HOST'] = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$_SERVER['HTTP_REFERER'] = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
$_SERVER['HTTP_USER_AGENT'] = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'HTTP Agent';
$_SERVER['LOCAL_ADDR'] = !empty($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : '0.0.0.0';
$_SERVER['REMOTE_ADDR'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
$_SERVER['REQUEST_SCHEME'] = !empty($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
$_SERVER['REQUEST_URI'] = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$_SERVER['SERVER_ADDR'] = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '0.0.0.0';
$_SERVER['SERVER_NAME'] = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
$_SERVER['SERVER_PORT'] = !empty($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '80';

/**
 * @todo Remove on production mode; used to analyze url calls. Save on test path only.
 */
file_put_contents($backend['paths']['__TEMP_PATH__'].'/access.log', "\r\n" . $_SERVER['REQUEST_URI'], FILE_APPEND | FILE_BINARY);

/**
 * A lot of scripts must often run from cron too.
 * So, there is a need to define it as a server, if absent.
 * If you want to alias a domain with one name, you can reset this value.
 * DO NOT modify this for localhost or other servers.
 * Rather consider using alias ID.
 * Sites without alias ID are a bit faster - as conversion is NOT required.
 */
$verify_installed_modules = function()
{
	/**
	 * Check for some standard PHP pre-requisites to run the system flawlessly
	 */
    $modules_missing = array();
	$modules_required = array(# Basic PHP
		'CURLFile' => 'curl_file_create',
		'cURL' => 'curl_init',
		'OpenSSL' => 'openssl_encrypt',
		'GD' => 'gd_info',
		'SPL' => 'spl_autoload',

		# Databases
		#'MySQL' => 'mysql_connect', # 2016-05-01 use with PHP7
		'MySQLi' => 'mysqli_connect', # Optional but very good
		#'pdo' => "",
		#'pdo_mysql' => "",
		#'pdo_sqlite' => "",

		# Other PHP Internals
		'Hash' => 'hash',
		'IconV' => 'iconv',
		'MCrypt' => 'mcrypt_module_open',
		'MB String' => 'mb_internal_encoding', # mb_get_info

		# API Development
		'DOM' => 'dom_import_simplexml',
		'SimpleXML' => 'simplexml_load_file',
		'SOAP' => 'is_soap_fault',
		'json' => 'json_encode',
	);
	foreach($modules_required as $module => $function)
	{
		if(!function_exists($function))
		{
            $modules_missing[] = $module;
		}
	}
    if($modules_missing)
    {
        die("<p>First, enable the following module(s) in php.ini to continue:</p><p>".implode(",<br />", $modules_missing)."</p>");
    }
};
$verify_installed_modules();

define('__APP_PATH__', $backend['paths']['__APP_PATH__']); # 
define('__LIBRARY_PATH__', $backend['paths']['__LIBRARY_PATH__']);
define('__SERVICES_PATH__', $backend['paths']['__SERVICES_PATH__']);
define('__LIVE__', $_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']);
define('__TEMP_PATH__', $backend['paths']['__TEMP_PATH__']);
define('__THIRD_PARTIES__', $backend['paths']['__LIBRARY_PATH__'] . '/vendors');

# At least don't mask error while creating a temp zone.
$subdomain_temp_zone = __TEMP_PATH__ . '/' . $_SERVER['SERVER_NAME'];
if(!(is_dir($subdomain_temp_zone) && is_writable($subdomain_temp_zone)))
{
	#die("Temp Zone: {$subdomain_temp_zone}");
	if(!mkdir($subdomain_temp_zone, 0777, true))
	{
		die("Failed to create temp zone: {$subdomain_temp_zone}.");
	}
}
#die($subdomain_temp_zone);
ini_set('error_log', $subdomain_temp_zone . '/' . @date('Ymd') . '.log');
ini_set('session.save_path', __TEMP_PATH__);
$ini = parse_ini_file(__LIBRARY_PATH__.'/inc/php.ini', true);
foreach($ini['backend'] as $key => $value)
{
	ini_set($key, $value);
}

/**
 * Smarty class initiation.
 * @todo New update caused issues with Auto Include.
 * @see http://stackoverflow.com/questions/8574794/importing-class-without-namespace-to-namespaced-class
 */
require_once(__THIRD_PARTIES__ . '/smarty/Smarty.class.php');
$smarty = new \Smarty();
/**
 * Compiled files are already protected, and are not available for direct download.
 * In each template files, it will add extra security script
 * @url http://www.smarty.net/forums/viewtopic.php?p=68369
 */
$smarty->direct_access_security = false;
# Also, suppress the header.
# May have to modify the Smarty itself.


require_once(__LIBRARY_PATH__.'/backend/class.backend.inc.php');
$backend_backend = new \backend\backend();
$backend_backend->log_access(true, __TEMP_PATH__.'/accessed-classes.log');
$backend_backend->setup(true);

$variable = new \common\variable();
$framework = new \backend\framework();

# First, reset the subdomain name, if an alias was used for local development
# Safely turn off this feature, if not needed on the server environment.
# Examples:
#   It can handle "www.domain.com" and "domain.com" as different server.
#   In this case, if you want same output, you will create an alias of
#     "domain.com" pointing to the id of server "www.domain.com" in the database.
# Query Subdomains (Alias ID)
$framework->reset_server_name_by_alias();

# Load defined constants for this subdomain.
$framework->load_user_defined_constants('config');

$subdomain_id = $framework->subdomain_id();
$subdomain_base = $framework->subdomain_base($subdomain_id);
#die("Debug notes:<br />\r\n \$subdomain_base: {$subdomain_base}, <br />\r\n \$subdomain_id: #{$subdomain_id}");
if(!defined('__SUBDOMAIN_BASE__'))
{
	# Give a chance for the super script define base.
	# You can skip this declaration here
	define('__SUBDOMAIN_BASE__', $subdomain_base);
}
if(!is_dir(__SUBDOMAIN_BASE__))
{
	die("Subdomain base (__SUBDOMAIN_BASE__) is not a directory: " . __SUBDOMAIN_BASE__);
}
chdir(__SUBDOMAIN_BASE__); # Enter inside the subdomain directory path

# Validates any missing constants with their suitable values.
# Importantly, __SUBDOMAIN_BASE__ is available here onwards.
require_once(__LIBRARY_PATH__ . '/inc/inc.constants.php');

# Avoid the risk of files being over-written when using common directory for all subdomains
$smarty->compile_id = preg_replace('/[^a-z]/is', "", $_SERVER['SERVER_NAME']);
$smarty->addPluginsDir(array(
	__SUBDOMAIN_BASE__ . '/plugins',
	__LIBRARY_PATH__ . '/plugins',
));
$smarty->setTemplateDir(__SUBDOMAIN_BASE__ . '/templates');
$smarty->setConfigDir(__SUBDOMAIN_BASE__ . '/configs');
$smarty->setCompileDir($subdomain_temp_zone);
$smarty->setCacheDir($subdomain_temp_zone);
$smarty->caching = false;
/**
 * Because when not writable, the page ends silently (White Screen).
 */
if(!is_writable($smarty->compile_dir))
{
	throw new \Exception("Unable to write to: chmod -R 777 {$smarty->compile_dir}");
}
if(!is_writable($smarty->cache_dir))
{
	throw new \Exception("Unable to write to: chmod -R 777 {$smarty->cache_dir}");
}
#$smarty->testInstall();

# Read subdomain specific configuration file
$service_config_file = __SUBDOMAIN_BASE__ . '/config.php';
$controller_location = __SUBDOMAIN_BASE__ . '/controllers';

/**
 * Handles session data from database.
 * Disable the below line if in case of performance issues.
 */
$session = new \backend\session();
session_start();

# Keep a log of unique visitors. It needs to access session data.
# So, it is used only after installing session handler.
$framework->log_browser_details($subdomain_id);

# Disable register globals variables. Here, we intend to turn them off.
# require_once(__LIBRARY_PATH__ . '/inc/inc.register_globals.php');

ob_start();
