<?php


# Created on: 2010-11-15 13:36:42 243

/**
 * Details of an entry in [ cdn ]
 */

$cdn_id = $variable->get('id', 'integer', 0); # Some IDs
$code = $variable->get('code', 'string', ""); # Protection Code

$cdn = new \subdomain\cdn();

# Try to load the details
if($cdn_details = $cdn->details($cdn_id, $code))
{
	$smarty->assignByRef('cdn', $cdn_details);
}
else
{
	# Record not found
	\common\stopper::url('cdn-direct-access-error.php');
}
