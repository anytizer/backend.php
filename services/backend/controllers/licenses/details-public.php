<?php


# Created on: 2011-02-10 00:12:27 318

/**
 * Details of an entry in [ licenses ]
 */

$license_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ''); # Protection Code

if(!$license_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('licenses-direct-access-error.php?context=identity');
}
else
{
	$licenses = new \subdomain\licenses();

	# Try to load the details
	if($licenses_details = $licenses->details($license_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('licenses', $licenses_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('licenses-direct-access-error.php?context=data');
	}
}
