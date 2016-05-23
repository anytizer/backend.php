<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Delete an entity in [ smtp ]
 */

$smtp = new \subdomain\smtp();

# Assumes, ID always, in the GET parameter
if(($smtp_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', '')))
{
	if($smtp->delete('inactivate', $smtp_id, $code))
	{
		#\common\stopper::url('smtp-delete-successful.php');
		\common\stopper::url('smtp-list.php');
	}
	else
	{
		\common\stopper::url('smtp-delete-error.php');
	}
}
else
{
	\common\stopper::url('smtp-direct-access-error.php');
}
