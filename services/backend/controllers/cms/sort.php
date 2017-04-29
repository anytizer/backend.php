<?php


# Created on: 2011-02-09 23:25:11 836

/**
 * Lists entities in cms
 */

$page_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ""); # For future references

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('query_pages', 'page_id', $page_id, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('cms-list.php');
#\common\stopper::url(\common\url::last_page('cms-list.php'));
