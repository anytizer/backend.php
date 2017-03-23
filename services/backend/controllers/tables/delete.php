<?php


# Created on: 2010-06-11 02:19:25 152

/**
 * Delete an entity in [ tables ]
 */

$tables = new \subdomain\tables();

# Assumes, ID always, in the GET parameter
if(($table_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', "")))
{
	if($tables->delete($table_id, $code))
	{
		#\common\stopper::url('tables-delete-successful.php');
		\common\stopper::url('tables-list.php');
	}
	else
	{
		\common\stopper::url('tables-delete-error.php');
	}
}
else
{
	\common\stopper::url('tables-direct-access-error.php');
}
