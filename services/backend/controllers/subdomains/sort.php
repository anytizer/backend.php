<?php


# Created on: 2011-02-10 00:27:11 536

/**
 * Lists entities in subdomains
 */

$subdomain_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ""); # For future references

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('query_subdomains', 'subdomain_id', $subdomain_id, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('subdomains-list.php');
#\common\stopper::url(\common\url::last_page('subdomains-list.php'));
