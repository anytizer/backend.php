<?php


# Created on: 2011-02-10 00:27:11 536

/**
 * Delete an entity in [ subdomains ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('subdomains-list.php');

$subdomains = new \subdomain\subdomains();

# Assumes, ID always, in the GET parameter
if(($subdomain_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', '')))
{
	if($subdomains->delete('inactivate', $subdomain_id, $code))
	{
		$messenger = new \common\messenger('warning', 'The record has been deleted.');

		#\common\stopper::url('subdomains-delete-successful.php');
		\common\stopper::url('subdomains-list.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record has NOT been deleted.');

		\common\stopper::url('subdomains-delete-error.php');
	}
}
else
{
	\common\stopper::url('subdomains-direct-access-error.php');
}
