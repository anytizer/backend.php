<?php
/**
 * # Detects a mobile version browser and sets the corresponding template
 * $is_mobile = $headers->is_mobile();
 * if($is_mobile)
 * {
 * # Appends "-mobile" in the template file.
 * # For example, "admin.php" template becomes "admin-mobile.php"
 * # For example, "frontend.php" tempalte becomes "frontend-mobile.php"
 * $page_details['template_file'] = preg_replace('/\.php/is', '-mobile.php', $page_details['template_file']);
 * }
 * $smarty->assign('is_mobile', $is_mobile);
 */

setlocale(LC_ALL, 'en_US.utf8');
# LC_ALL: LC_CTYPE | LC_COLLATE | LC_MESSAGES| LC_MONETARY | LC_NUMERIC | LC_TIME


# Global configuration file, created on __TIMESTAMP__ for __SUBDOMAIN_NAME__
# Remove this file, if it does NOT have anything configured here.
# Every configurations will be available publicly to the entities under this subdomain.


/**
 * $logged_on = $variable->session('logged_on', 'integer', 0); # It will be the time() of last successful login.
 * $user_id   = $variable->session('user_id',   'integer', 0); # Who has logged in currently? 0 = No user.
 * # Proceed only if the page requires a login
 * if($page_details['needs_login']!='N')
 * {
 * # Search for login, if done already.
 * # $logged_on!==true, if boolean flag used. Otherwise, time() of last login.
 * if(!$user_id || !$logged_on)
 * {
 * # Jump to the first clicked page that required the login.
 * # Commenting the below line will jump to the last clicked page that required the login
 * #if(!isset($_SESSION['goto']))
 * {
 * # We will redirect to $_SESSION['goto'] once the user logs in successfully.
 * # Avoid using login.php, logout.php => go to home page in these cases.
 * # Rather go to home page.
 * if(preg_match('/\/log(in|out)?.php$/s', $_SERVER['REQUEST_URI'], $data))
 * {
 * # Do not allow to enter to login/logout pages.
 * $_SERVER['REQUEST_URI'] = './';
 * }
 * # Remember the current page to go after successful login
 * $_SESSION['goto'] = $_SERVER['REQUEST_URI'];
 * }
 * # Be sure that it is not having a needs_login=Y flag.
 * # Otherwise, it results in a looping redirections.
 * \common\stopper::url('login.php'); # Force to redirect to login page
 * #$smarty->display('login.php'); die(); # Rather show the login form immediately in the same page
 * }
 * }
 */


/**
 * Use this block programatically only, and only if you have implemented
 * the logics of controlling admin-login requirements in the database flag.
 * You can set the super admin flag (is_admin) while user logs in.
 * Avoid the normal users access the admin pages
 * /
 * if($page_details['is_admin']=='Y' && !$_SESSION['is_admin'])
 * {
 * \common\stopper::url('permission-denied.php');
 * }
 */

/**
 * Load the User Levels who logged in. Eg, entities-lists.php or entities.php
 *
 * @see |details kind of plugins
 */
!defined('IS_ADMINISTRATOR') && define('IS_ADMINISTRATOR', isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true);

/**
 * Determine, if the server is running in production mode
 * @todo Enter the domain name with all aliases used
 */
function is_live()
{
	return in_array($_SERVER['SERVER_NAME'], array('__SUBDOMAIN_NAME__')) && $_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR'];
}

/**
 * For template text changes, load the configuration file.
 * You can load multiple files if you need.
 * These configurations are shared via $configurations variable to the controllers.
 */
$smarty->configLoad('__SUBDOMAIN_NAME__.conf');
$configurations = $smarty->config_vars;