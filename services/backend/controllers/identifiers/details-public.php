<?php


# Created on: 2011-03-18 13:20:47 198

/**
 * Details of an entry in [ identifiers ]
 */

$identifier_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ''); # Protection Code

if(!$identifier_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('identifiers-direct-access-error.php?context=identity');
}
else
{
	$identifiers = new \subdomain\identifiers();

	# Try to load the details
	if($identifiers_details = $identifiers->details($identifier_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('identifiers', $identifiers_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('identifiers-direct-access-error.php?context=data');
	}
}
