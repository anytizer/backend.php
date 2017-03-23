<?php
#__DEVELOPER-COMMENTS__

/**
 * Login user authentication
 */

$session_message = isset($_SESSION['messenger']) ? $_SESSION['messenger'] : array();

# Which email address is being used?
$attempted_email = isset($_SESSION['attempted_email']) ? $_SESSION['attempted_email'] : "";
$attempted_email = isset($_GET['username']) ? base64_decode($_GET['username']) : $attempted_email;

$login = new \subdomain\login_manager();

$login_action = $variable->post('login-action', 'string', "");
if($login_action)
{
	$username = $variable->post('username', 'string', "");
	$password = $variable->post('password', 'string', "");

	$goto_page = './';
	$secure = new \common\secure();
	if($secure->is_secured())
	{
		if($login->login_user($username, $password))
		{
			if($goto = $variable->post('goto', 'string', ""))
			{
				$goto_page = $goto;
			}
			else if($goto = $variable->session('goto', 'string', ""))
			{
				# Unset it, and make it ready for other pages / login
				unset($_SESSION['goto']);
				$goto_page = $goto;
			}

			# Do not go to login form again, after a successful login
			# $goto_page=(strtolower($goto_page)!='login.php')?$goto_page:'./?rand='.\common\tools::random_text(5);
			$goto_page = 'dashboard.php';
		}
		else
		{
			# Kick off the user and mention - login failed.
			$login->logout_user();
			$goto_page = 'login-failed.php';
			$messenger = new \common\messenger('error', 'Login failed. Please type your username and password correctly.');
		}
	}
	else
	{
		# Kick off the user and mention - login failed.
		$login->logout_user();
		$goto_page = 'login-failed.php?reason=captcha';
		$messenger = new \common\messenger('error', 'Invalid security code.');
	}
	\common\stopper::url($goto_page);
}
else
{
	# Optionally, logout the use as well, as soon as the login page is requested.
	$variable->kill('session', 'user_id');
}

# Continues to show the default login form.
if(empty($_SESSION['messenger']))
{
	$_SESSION['messenger'] = $session_message;
}
