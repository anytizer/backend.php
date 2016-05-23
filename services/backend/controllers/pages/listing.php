<?php


$pagination = new \common\pagination('p', __PER_PAGE__); # Parameter: GET[], and per page

$pagination_sql = "
SELECT SQL_CALC_FOUND_ROWS
	page_name `name`,
	page_title `title`
FROM `query_pages`
LIMIT {$pagination->page_limits()}
;";
#echo($pagination_sql);
$db->query($pagination_sql);
$pages = $db->to_array(); # Data

$counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
$totals = $db->row($counter_sql);
$pagination->set_total($totals['total']); # Must Do

# Assign to PHP
$smarty->assignByRef('pages', $pages); # Data
$smarty->assignByRef('pagination', $pagination);
