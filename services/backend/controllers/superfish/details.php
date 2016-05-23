<?php


# Created on: 2011-02-02 00:36:55 983

/**
 * Details of an entry in [ superfish ]
 */

$menu_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ''); # Protection Code

if(!$menu_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('superfish-direct-access-error.php?context=identity');
}
else
{
	$superfish = new \subdomain\superfish();

	# Try to load the details
	if($superfish_details = $superfish->details($menu_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('superfish', $superfish_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('superfish-direct-access-error.php?context=data');
	}
}
