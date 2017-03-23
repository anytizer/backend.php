<?php


# Created on: 2010-06-11 02:19:25 152

/**
 * Add an entity in [ tables ]
 */

$tables = new \subdomain\tables();

if($variable->post('add-action', 'string', ""))
{
	# Posted Data: Apply security
	$data = $variable->post('tables', 'array', array());
	$data['export_query'] = ""; # Not yet implemented.
	$data['is_active'] = 'Y';

	if($table_id = $tables->add($data))
	{
		#\common\stopper::url('tables-add-successful.php');
		#\common\stopper::url('tables-list.php');

		# Once successfully added, as the admin user to edit the data.
		\common\stopper::url('tables-edit.php?id=' . $table_id);
	}
	else
	{
		\common\stopper::url('tables-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('tables-direct-access-error.php');
}

$smarty->assign('protection_code', $tables->code());
