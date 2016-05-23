<?php


# Created on: 2011-03-23 11:38:46 911

/**
 * Sorts emails by changing the sinking weight.
 * Extended fetures can sort the data within the set of record (categories) only.
 */

$email_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ''); # For future references

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('query_emails', 'email_id', $email_id, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('emails-list.php');
#\common\stopper::url(\common\url::last_page('emails-list.php'));
