<?php
declare(strict_types=1);

# Framework Bootstrap Loader
require_once('inc.bootstrap.php');
if(!is_file("{$backend['paths']['__APP_PATH__']}/database/license.ini"))
{
	header('Location: install/');
	exit(-1);
}

require_once($backend['paths']['__LIBRARY_PATH__'].'/inc/inc.config.php');

# Please do not cache me.
$headers = new \common\headers();
$headers->no_cache();

# Down the site for denial of service attack
# $dos = new dos(0); # DOS attack filter: 500000: 1/4th of a second

# Make these objects instantly available to all included controllers.
$db = new \common\mysql();

# What is the file being requested?
# If not found, assume it as index.php.
$page = $variable->get('page', 'string', 'index.php');

# Serve case-insensitive page names.
# This globally affects the pages that are rendered through this script.
# It will affect the controller files being used.
# Do not use the line below, to make the website become case SeNsItIvE in URL names.
# Page names in the database too should follow this. (Normally, insensitive). Use VARBINARY field type.
# Windows server has nothing to do with this feature, while it matters on Linux server.
$page = strtolower($page);

# Processes rewrite.ini file within a subdomain.
# Installs the URL rewriter - It will reset _GET and $page records.
$rewriter = new \backend\rewriter();
if($vars = $rewriter->process($page))
{
	# Warning: $page is a reserved variable.
	# Use this protection only on demand.

	# Warning: Extracting may collide with variable $page.
	# ToDo: Backup $page and validate after extraction.
	# if(isset($vars['page'])) unset($vars['page']);

	extract($vars, EXTR_OVERWRITE);
	unset($vars);
}

# Assign it later only, to make sure that it takes the changes made by the rewriter.
$smarty->assign('page_name', $page);

$pages = new \backend\pages();
$page_details = $pages->get_current_page($page);
if($page_details)
{
	# Check, if the site is down
	if($page_details['is_down'] == 'Y')
	{
		# Turns off the website into offline mode
		\common\stopper::message("Page/<strong>Site</strong> is down at the moment. Please contact an administrator.");
	}

	# Basic meta text sensitization
	$page_details['meta_keywords'] = str_replace("\"", "\\\"", $page_details['meta_keywords']);
	$page_details['meta_description'] = str_replace("\"", "\\\"", $page_details['meta_description']);

	# \common\stopper::debug($page_details, false);
	# Definitely, process a registered module.
	# require_once('library/inc/inc.registered-module.php');

	# Try to load the service specific config file,
	# as defined globally in library/inc/inc.config.php
	if(isset($service_config_file) && file_exists($service_config_file) && is_file($service_config_file))
	{
		# Needed only for subdomain services. Used before the controllers.
		# Pattern: /library/SERVER_NAME/config.mysql.inc.php
		require_once($service_config_file);
	}

	# If file name does not contain, '/' character,
	# it is NOT having a no-directory instructions.
	if(($valid_file_name = \common\tools::php_filename($page)) == "")
	{
		\common\stopper::message("Invalid filename/php: <strong>{$page}</strong>. It should pass \common\tools::php_filename().");
	}

	$controller_file = $controller_location . '/' . $valid_file_name;
	if(is_file($controller_file))
	{
		# Try to use this kind of controller file
		require_once($controller_file);
	}
	else
	{
		# For development only, it should not be active in production version.
		# It helps to group a set of files in their own directories.
		# Example: "/mysql-backup.php" is located in: "/mysql/backup.php".
		# Example: "/mysql-backup-everything.php" is located in: "/mysql/backup-everyting.php".
		# Valid actions in an entity are:
		#    add
		#    delete
		#    details
		#    details-public
		#    edit
		#    list
		#    list-public
		# There are other parameters as well.
		# Please refer to sqls/install-entity.sql for more details.
		# And, if you add your own actions, it will follow the same patterns.

		$controller_pattern = '/\/([a-z0-9]+)\-([a-z0-9\-]+)\.php$/';
		$controller_file_new = preg_replace($controller_pattern, '/$1/$2.php', $controller_file);
		if(file_exists($controller_file_new) && is_file($controller_file_new))
		{
			# Use the controller file
			require_once($controller_file_new);
		}
		else
		{
			# Handle the absence of controller files.
			# Absenteeism is valid even in production mode.
			# When a controller is absent, it cannot interact with GET/POST or other calculations.
			# \common\stopper::message('None of the controllers exist:<br>1. '.$controller_file.',<br>2. '.$controller_file_new);
		}
	}

	# Valid page: Process it now.
	if(!empty($page_details['is_active']) && $page_details['is_active'] == 'Y')
	{
		# Allow the templates use the page details.
		$smarty->assign('page', $page_details);

		# Assign the template file from the database or page details

		# default template file in this framework
		# All other templates cannot be customized for any purpose.
		$template_default = 'management.php';

		$template_file = !empty($page_details['template_file']) ? $page_details['template_file'] : $template_default;
		if($template_file == $template_default)
		{
			# Search, if the template file was customized in query_subdomains
			# Somewhere, write to session variable: template_file, if required.
			$template_file = $variable->session('template_file', 'string', $template_default);
		}

		if($smarty->templateExists($template_file))
		{
			$smarty->display($template_file);
		}
		else
		{
			$template_dir = is_array($smarty->template_dir) ? $smarty->template_dir[0] : $smarty->template_dir;
			\common\stopper::message("
<h2>Missing Template:</h2>
<p><strong>{$template_dir}/<em>{$template_file}</em></strong> for: {$page}</p>

<div>
	<h1>__SUBDOMAIN_BASE__: " . (defined('__SUBDOMAIN_BASE__') ? __SUBDOMAIN_BASE__ : "") . "</h1>
	<h2>List of possible templates:</h2>
	<div>
		" . nl2br(print_r($smarty->template_dir, true)) . "
	</div>
	<h2>Page details:</h2>
	<div>
		" . nl2br(print_r($page_details, true)) . "
	</div>
</div>
");
		}
	}
	else
	{
		\common\headers::error404();

		# Gracefully show up the error messages.
		if($smarty->templateExists('404.php'))
		{
			# Use system's 404 error template.
			$smarty->display('404.php');
		}
		else
		{
			# The page was NOT really found.
			\common\stopper::message('404 Error. Error template also does not exist. Page: ' . $page, false);
		}
	}
}
else
{
	$subdomain = new subdomains();
	$subdomain_details = $subdomain->current_subdomain();

	$message = "
<p><strong>{$page}</strong> @ {$_SERVER['SERVER_NAME']}</p>
<p>Shareable modules disabled or 404 error. | Or, <strong>CRUD missing</strong>.</p>
<p>Current subdomain and alias are: <strong>{$subdomain_details}</strong>.</p>
<p>
	If you created this subdomain <strong>recently</strong>,
	please <em>consider registering</em> the default pages.
</p>
<p>In case of <strong>exported subdomains</strong>, check that the server name is alias with the development version. Then re-export the subdomain database scripts.</p>
<p>If this is the first time, you have to import the database and tables correctly. Please refer to: install/sql-scripts/*.sh or install/sql-scripts/*.bat files.</p>
";

	$smarty->assign('message', $message);

	\common\headers::error404();

	# Gracefully show up the error messages.
	if($smarty->templateExists('404.php'))
	{
		# Use system's 404 error template.
		$smarty->display('404.php');
	}
	else
	{
		# it could be a 404 error, or a shareable module like syndicated
		\common\stopper::message($message);

		# Sub Directory
		# Locally registered module only, called by index page only.
		# The most common type of pages who use query_pages.

		# Try: a registered third party application (module) check
		# Burden warning:
		# Each css, js, images, and everything else is handled by php scripts, here.

		# This is a very expensive method
		require_once('library/modules/inc.modules.php');
		/*
		#Rather, say sorry.
		# \common\stopper::message('Sorry, this page does not exist: '.$page, false);
		# Gracefully show up the error messages.
		if($smarty->templateExists('404.php'))
		{
			$smarty->display('404.php');
		}
		else
		{
			\common\stopper::message('Sorry, this page does not exist: '.$page, false);
		}
		*/
	}
}
