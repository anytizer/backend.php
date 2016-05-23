<?php


# Created on: 2009-11-11 20:01:53 711

/**
 * Delete an entity in [ menus ]
 */

if(($menus_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', '')))
{
	$menus = new \subdomain\menus();
	if($menus->delete($menus_id, $code))
	{
		\common\stopper::url('menus-delete-successful.php');
	}
	else
	{
		\common\stopper::url('menus-delete-error.php');
	}
}
else
{
	\common\stopper::url('menus-direct-access-error.php');
}
