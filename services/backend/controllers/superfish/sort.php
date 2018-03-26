<?php




/**
 * Lists entities in superfish
 */

$menu_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ""); # For future references

# Find out the direction to sort. Go upwards or downloads in the list.
$direction = strtolower($variable->get('direction', 'string', 'down'));
$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

# Sort only within a context only in which the record exists
$context_sql = "SELECT `context` FROM query_dropdowns WHERE menu_id={$menu_id};";
$context = $db->row($context_sql);
if (!isset($context['context'])) {
    $context = array(
        'context' => "",
    );
} else {
    $context['context'] = addslashes($context['context']);
}

# Match active records (and optionally other condistions)
$sorter = new \backend\sorter("AND `is_active`='Y' AND `context`='{$context['context']}'");
$sorter->sort_table('query_dropdowns', 'menu_id', $menu_id, $direction, 'sink_weight');

$messenger = new \common\messenger('warning', 'The record has been sorted.');

# This is a controller only page and does not have anything to display.
\common\headers::back('superfish-list.php');
#\common\stopper::url(\common\url::last_page('superfish-list.php'));
