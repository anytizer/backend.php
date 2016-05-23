<?php
/**
 * Changes the user password when confirmed
 */
if($variable->post('change-password', 'string', ''))
{
	$lm = new login_manager();

	$data = $variable->post('password', 'array', array());

	$user_id = $variable->session('user_id', 'integer', 0);
	$password_old = $variable->read($data, 'old', 'string', '');
	$password_new = $variable->read($data, 'new', 'string', '');
	$password_confirm = $variable->read($data, 'confirm', 'string', '');

	if($lm->password_change($user_id, $password_old, $password_new, $password_confirm))
	{
		$lm->notify_password_changed($user_id, $password_new);
		\common\stopper::url('password-changed-successfully.php');
	}
	else
	{
		\common\stopper::url('password-change-failed.php');
	}
}
else
{
	# Just load the password change form here.
}
