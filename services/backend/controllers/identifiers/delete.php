<?php


# Created on: 2011-03-18 13:20:47 198

/**
 * Delete an entity in [ identifiers ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('identifiers-list.php');

$identifiers = new \subdomain\identifiers();

# Assumes, ID always, in the GET parameter
if(($identifier_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', '')))
{
	if($identifiers->delete('inactivate', $identifier_id, $code))
	{
		$messenger = new \common\messenger('warning', 'The record has been deleted.');

		#\common\stopper::url('identifiers-delete-successful.php');
		\common\stopper::url('identifiers-list.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record has NOT been deleted.');

		\common\stopper::url('identifiers-delete-error.php');
	}
}
else
{
	\common\stopper::url('identifiers-direct-access-error.php');
}
