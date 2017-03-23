<?php


# Created on: 2011-02-09 23:25:11 836

/**
 * Details of an entry in [ cms ]
 */

$page_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if(!$page_id)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('cms-direct-access-error.php?context=identity');
}
else
{
	$cms = new \subdomain\cms();

	# Try to load the details
	if($cms_details = $cms->details($page_id, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('cms', $cms_details);
	}
	else
	{
		# Record not found
		\common\stopper::url('cms-direct-access-error.php?context=data');
	}
}
