<?php


# Created on: 2010-12-27 11:38:12 391

/**
 * Lists entities in history
 */

$history_id = $variable->get('id', 'integer', 0);

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y'");
$sorter->sort_table('query_development_history', 'history_id', $history_id, $direction, 'sink_weight');

# This is a controller only page and does not have anything to display.
\common\headers::back('history-list.php');
#\common\stopper::url(\common\url::last_page('history-list.php'));
