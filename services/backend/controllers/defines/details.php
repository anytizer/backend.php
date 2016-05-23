<?php


# Created on: 2010-06-16 21:19:04 969

/**
 * Details of an entry in [ defines ]
 */

$define_id = $variable->get('id', 'integer', 0); # Some IDs
$code = $variable->get('code', 'string', ''); # Protection Code

$defines = new \subdomain\defines();

$defines_details = $defines->details($define_id, $code);
$smarty->assignByRef('defines', $defines_details);
