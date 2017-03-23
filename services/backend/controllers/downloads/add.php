<?php


# Created on: 2010-12-14 00:48:38 194

/**
 * Add an entity in [ downloads ]
 */

$downloads = new \subdomain\downloads();

if($variable->post('add-action', 'string', ""))
{
	# Posted Data: Apply security
	$data = $variable->post('downloads', 'array', array());

	# Immediately activate the record
	$data['is_active'] = 'Y';

	# When this record is added for the first time?
	$data['added_on'] = 'CURRENT_TIMESTAMP()';

	if($distribution_id = $downloads->add($data))
	{
		\common\stopper::url(\common\url::last_page('downloads-list.php'));
		#\common\stopper::url('downloads-add-successful.php');
		#\common\stopper::url('downloads-list.php');

		# Once successfully added, as the admin user to edit the data.
		#\common\stopper::url('downloads-edit.php?id='.$distribution_id);
	}
	else
	{
		\common\stopper::url('downloads-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('downloads-direct-access-error.php');

	# Purpose of this code block is to make sure that the variable
	# gets all indices with blank data, to feed to ADD form.

	# A dynamic details about this record
	$details = array();

	# Validate it against the parameters in itself, plus those what we need.
	$details = $downloads->validate('add', $details);
	$smarty->assign('downloads', $details);
}

$smarty->assign('protection_code', $downloads->code());
