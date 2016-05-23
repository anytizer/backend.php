<?php
/**
 * Helps to take a website offline.
 */

/**
 * Framework Bootstrap Loader should be always used first, anywhere.
 */
require_once('library/inc/inc.config.php');

if(isset($_GET['go']) && $_GET['go'] === 'true') # string
{
	$_SESSION['simulate_live'] = true;
}
else
{
	/**
	 * GO parameter is not available all the times.
	 * Protect it.
	 */
	if(!isset($_SESSION['simulate_live']))
	{
		$_SESSION['simulate_live'] = false;
	}
}

if(!$_SESSION['simulate_live'] === true)
{
	/**
	 * Do not continue serving the original files.
	 */
	require_once(dirname(__FILE__) . '/under-construction.php');
}