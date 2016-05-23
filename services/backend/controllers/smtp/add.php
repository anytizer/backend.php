<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Add an entity in [ smtp ]
 */

$smtp = new \subdomain\smtp();

if($variable->post('add-action', 'string', ''))
{
	# Posted Data: Apply security
	$data = $variable->post('smtp', 'array', array());
	$data['is_active'] = 'Y'; # Immediately activate the record
	$data['smtp_identifier'] = strtoupper($data['smtp_identifier']);
	# $data['added_on'] = 'CURRENT_TIMESTAMP()'; # When this record is added?

	if($smtp_id = $smtp->add($data))
	{
		#\common\stopper::url('smtp-add-successful.php');
		#\common\stopper::url('smtp-list.php');

		# Once successfully added, as the admin user to edit the data.
		\common\stopper::url('smtp-edit.php?id=' . $smtp_id);
	}
	else
	{
		\common\stopper::url('smtp-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('smtp-direct-access-error.php');

	# Validate it against the parameters in itself, plus those what we need.
	$details = array();
	$details = $smtp->validate('add', $details);
	$smarty->assign('smtp', $details);
}

$smarty->assign('protection_code', $smtp->code());
