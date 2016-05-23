<?php
#__DEVELOPER-COMMENTS__

# Created on: 2011-03-22 12:55:36 802

/**
 * Add an entity in [ customers ]
 */

$customers = new customers();

if($variable->post('add-action', 'string', ''))
{
	# Posted Data: Apply security
	$data = $variable->post('customers', 'array', array());

	# Immediately activate the record
	$data['is_active'] = 'N';

	# When this record is added for the first time?
	$data['added_on'] = 'CURRENT_TIMESTAMP()';

	$ln = new login_manager();
	$data['customers_password'] = zen_encrypt_password($password = \common\tools::random_text(5));
	$data['activation_code'] = \common\tools::random_text(5);

	if($customers_id = $customers->add($data, false))
	{
		$messenger = new \common\messenger('success', 'Customer record is registered. Please check your email and click on the activation link.');
		$_SESSION['attempted_email'] = $data['customers_email_address'];

		$customers->notify_self_registration($customers_id, $password);

		# Self regisration successful message
		#\common\stopper::url('customers-self-registration-successful.php');
		\common\stopper::url('login.php?username=' . base64_encode($data['customers_email_address']));
	}
	else
	{
		$messenger = new \common\messenger('error', 'Record is not registered. Probably your email address is already in use.');

		#\common\stopper::url('customers-add-error.php');
		$_SESSION['registration_attempt'] = $data;
		\common\stopper::url('register.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('customers-direct-access-error.php');

	# Purpose of this code block is to make sure that the variable
	# gets all indices with blank data, to feed to ADD form.

	# A dynamic details about this record
	$details = array();

	if(isset($_SESSION['registration_attempt']))
	{
		$details = $_SESSION['registration_attempt'];
		unset($_SESSION['registration_attempt']);
	}

	# Validate it against the parameters in itself, plus those what we need.
	$details = $customers->validate('add', $details);
	$smarty->assign('customers', $details);
}

$smarty->assign('protection_code', $customers->code());
