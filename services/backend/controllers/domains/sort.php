<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Lists entities in domains
 */

$domain_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ""); # For future references

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('localhost_domains', 'domain_id', $domain_id, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('domains-list.php');
#\common\stopper::url(\common\url::last_page('domains-list.php'));
