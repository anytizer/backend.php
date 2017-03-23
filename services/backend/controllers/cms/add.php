<?php


# Created on: 2011-02-09 23:25:11 836

/**
 * Add an entity in [ cms ]
 */

$cms = new \subdomain\cms();

if($variable->post('add-action', 'string', ""))
{
	# Posted Data: Apply security
	$data = $variable->post('cms', 'array', array());

	# Immediately activate the record
	$data['is_active'] = 'Y';

	# When this record is added for the first time?
	$data['added_on'] = 'CURRENT_TIMESTAMP()';

	if($page_id = $cms->add($data, false))
	{
		$messenger = new \common\messenger('success', 'The record has been added.');

		\common\stopper::url(\common\url::last_page('cms-list.php'));
		#\common\stopper::url('cms-add-successful.php');
		#\common\stopper::url('cms-list.php');

		# Once successfully added, as the admin user to edit the data.
		#\common\stopper::url('cms-edit.php?id='.$page_id);
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

		\common\stopper::url('cms-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('cms-direct-access-error.php');

	# Purpose of this code block is to make sure that the variable
	# gets all indices with blank data, to feed to ADD form.

	# A dynamic details about this record
	$details = array();

	# Validate it against the parameters in itself, plus those what we need.
	$details = $cms->validate('add', $details);
	$smarty->assign('cms', $details);
}

$smarty->assign('protection_code', $cms->code());
