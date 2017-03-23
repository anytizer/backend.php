<?php


# Created on: 2011-02-02 00:36:55 983

/**
 * Delete an entity in [ superfish ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('superfish-list.php');

$superfish = new \subdomain\superfish();

# Assumes, ID always, in the GET parameter
if(($menu_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', "")))
{
	if($superfish->delete('inactivate', $menu_id, $code))
	{
		$messenger = new \common\messenger('warning', 'The record has been deleted.');

		#\common\stopper::url('superfish-delete-successful.php');
		\common\stopper::url('superfish-list.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record has NOT been deleted.');

		\common\stopper::url('superfish-delete-error.php');
	}
}
else
{
	\common\stopper::url('superfish-direct-access-error.php');
}
