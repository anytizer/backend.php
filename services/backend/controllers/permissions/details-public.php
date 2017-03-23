<?php


# Created on: 2011-03-29 23:48:23 316

/**
 * Details of an entry in [ permissions ]
 */

$crud_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if(!$crud_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('permissions-direct-access-error.php?context=identity');
}
else
{
	$permissions = new \subdomain\permissions();

	# Try to load the details
	if($permissions_details = $permissions->details($crud_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('permissions', $permissions_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('permissions-direct-access-error.php?context=data');
	}
}
