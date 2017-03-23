<?php


# Created on: 2010-12-27 11:38:12 391

/**
 * Add an entity in [ history ]
 */

$history = new \subdomain\history();

if($variable->post('add-action', 'string', ""))
{
	# Posted Data: Apply security
	$data = $variable->post('history', 'array', array());

	$data['subdomain_id'] = (int)$data['subdomain_id'];

	# Immediately activate the record
	$data['is_active'] = 'Y';

	# When this record is added for the first time?
	$data['added_on'] = 'CURRENT_TIMESTAMP()';

	if($history_id = $history->add($data))
	{
		\common\stopper::url(\common\url::last_page('history-list.php'));
		#\common\stopper::url('history-add-successful.php');
		#\common\stopper::url('history-list.php');

		# Once successfully added, as the admin user to edit the data.
		#\common\stopper::url('history-edit.php?id='.$history_id);
	}
	else
	{
		\common\stopper::url('history-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('history-direct-access-error.php');

	# Purpose of this code block is to make sure that the variable
	# gets all indices with blank data, to feed to ADD form.

	# A dynamic details about this record
	$details = array();

	# Validate it against the parameters in itself, plus those what we need.
	$details = $history->validate('add', $details);
	$smarty->assign('history', $details);
}

$smarty->assign('protection_code', $history->code());
