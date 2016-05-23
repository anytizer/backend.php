<?php
$pages = new \subdoamin\pages();
$subdomain_id = 27;

if($page_id = $variable->get('id', 'integer', 0))
{
	$direction = $variable->get('direction', 'string', 'down');
	$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

	$sorter = new \backend\sorter("AND `is_active`='Y' AND `subdomain_id`='{$subdomain_id}'");
	$sorter->sort_table('query_pages', 'page_id', $page_id, $direction, 'sink_weight');

	\common\stopper::url('pages-sort.php');
}
else
{
	$entries = $pages->list_pages_for_sorting_in_sitemap($subdomain_id);
	$smarty->assignByRef('pagess', $entries);
}
