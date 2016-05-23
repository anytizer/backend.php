<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Delete an entity in [ domains ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('domains-list.php');

$domains = new \subdomain\domains();

# Assumes, ID always, in the GET parameter
if(($domain_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', '')))
{
	if($domains->delete('inactivate', $domain_id, $code))
	{
		$messenger = new \common\messenger('warning', 'The record has been deleted.');

		#\common\stopper::url('domains-delete-successful.php');
		\common\stopper::url('domains-list.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record has NOT been deleted.');

		\common\stopper::url('domains-delete-error.php');
	}
}
else
{
	\common\stopper::url('domains-direct-access-error.php');
}
