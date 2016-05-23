<?php
#print_r($_POST);
/*
Array
(
    [email] => asdf@asdf.com
    [action] => Password forgot
    [password-forgot-action] => Submit
)*/

$email = \common\tools::sanitize($variable->post('email', 'string', ''));
$smarty->assign('email', $email);

if($variable->post('action', 'string', ''))
{
	$_SESSION['attempted_email'] = $email;

	$user_precheck_sql = "#";
	if($customer = $db->row($user_precheck_sql))
	{
		$password = new password();
		$newpassword = \common\tools::random_text(5);
		$newpassword_zen = $password->encrypt_password($newpassword);
		$update_sql = "#";
		#die($update_sql);
		$db->query($update_sql);

		$messenger = new \common\messenger('notice', 'Your password has been reset.');

		$email_template = new email_template('YYYYMMDDHHIISSXXXX');
		$sender = new sender('');
		$sender->ClearAddresses();
		$sender->add_recipient(new datatype_recipient('', ''));
		$sender->add_recipient(new datatype_recipient('', ''));
		$sample_data = array(
			# Customer Data
		);
		$email_data = $email_template->read_template($sample_data);
		if($success = $sender->deliver($email_data))
		{
			$messenger = new \common\messenger('success', 'We have sent a new password into your email address. Please check your email first and use your password.');
		}
		else
		{
			$messenger = new \common\messenger('error', 'Your email is valid and password is reset. But we could NOT deliver you an email.');
		}
		\common\stopper::url('login.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'This email address does not exist.');
		\common\stopper::url('password-forgot.php');
	}
}

$smarty->assign('email', isset($_SESSION['attempted_email']) ? $_SESSION['attempted_email'] : $email);
