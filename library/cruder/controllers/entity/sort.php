<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Sorts __ENTITY__ by changing the sinking weight.
 * Extended features can sort the data within the set of record (categories) only.
 */

$__PK_NAME__ = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ""); # For future references

$__ENTITY__ = new \subdomain\__ENTITY__();
$data = $__ENTITY__->details($__PK_NAME__, $code);
if(!$data)
{
	$messenger = new \common\messenger('error', 'No such data to sort.');
	\common\headers::back('__ENTITY__-list.php');
}

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other conditions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('__TABLE__', '__PK_NAME__', $__PK_NAME__, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('__ENTITY__-list.php');
#\common\stopper::url(\common\url::last_page('__ENTITY__-list.php'));
