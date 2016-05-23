<?php
$login_action = $variable->post('login-action', 'string', '');

if($login_action)
{
	$username = $variable->post('username', 'string', '');
	$password = $variable->post('password', 'string', '');

	$lp = new \subdomain\login_manager();
	if($lp->login_user($username, $password))
	{
		if($goto = $variable->session('goto', 'string', ''))
		{
			# Unset it, and make it ready for other pages
			unset($_SESSION['goto']);

			\common\stopper::url($goto);
		}
		else if($goto = $variable->post('goto', 'string', ''))
		{
			\common\stopper::url($goto);
		}
		else
		{
			\common\stopper::url('./');
		}
	}
	else
	{
		$lp->logout_user();
		\common\stopper::message('Login failed...');
	}
}
