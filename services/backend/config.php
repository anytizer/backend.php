<?php
# Your global configuration
$logged_on = $variable->session('logged_on', 'boolean', false);
$user_id = $variable->session('user_id', 'integer', 0);
$variable->write('session', 'user_id', $user_id);

#die('err:'.__LINE__);
#print_r($page_details);
if($page_details['needs_login'] != 'N')
{
	#die('err:'.__LINE__);# Search for login, if done already
	if(!$user_id || !$logged_on)
	{
		if(!isset($_SESSION['goto']))
		{
			$_SESSION['goto'] = $_SERVER['REQUEST_URI'];
		}
		$smarty->display('login.php');
		die();
		#\common\stopper::url('login.php');
	}
}


$smarty->assign('page_details', $page_details);

# Here, put your own configuration file to customize the value
#die('err:'.__LINE__);
$smarty->configLoad('backend.conf');
#die('err:'.__LINE__);
#print_r($_SESSION);
?>