<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Details of an entry in [ domains ]
 */

$domain_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if(!$domain_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('domains-direct-access-error.php?context=identity');
}
else
{
	$domains = new \subdomain\domains();

	# Try to load the details
	if($domains_details = $domains->details($domain_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('domains', $domains_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('domains-direct-access-error.php?context=data');
	}
}
