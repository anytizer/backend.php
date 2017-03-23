<?php


# Created on: 2010-12-14 00:48:38 194

/**
 * Details of an entry in [ downloads ]
 */

$distribution_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if(!$distribution_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('downloads-direct-access-error.php?context=identity');
}
else
{
	$downloads = new \subdomain\downloads();

	# Try to load the details
	if($downloads_details = $downloads->details($distribution_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('downloads', $downloads_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('downloads-direct-access-error.php?context=data');
	}
}
