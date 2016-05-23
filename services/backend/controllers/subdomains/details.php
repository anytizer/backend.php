<?php


# Created on: 2011-02-10 00:27:11 536

/**
 * Details of an entry in [ subdomains ]
 */

$subdomain_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ''); # Protection Code

if(!$subdomain_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('subdomains-direct-access-error.php?context=identity');
}
else
{
	$subdomains = new \subdomain\subdomains();

	# Try to load the details
	if($subdomains_details = $subdomains->details($subdomain_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('subdomains', $subdomains_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('subdomains-direct-access-error.php?context=data');
	}
}
