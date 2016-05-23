<?php


# Sample URLs
# menus-sort.php?context=framework:admin&id=25&direction=up
# menus-sort.php?context=framework:admin&id=25&direction=down

$menus = new \subdomain\menus();
$menu_context = $variable->get('context', 'string', '');
$menu_context = \common\tools::safe_sql_word($menu_context);

if($menu_id = $variable->get('id', 'integer', 0))
{
	# Proceed to sorting the menu
	$direction = $variable->get('direction', 'string', 'down');
	$direction = (in_array($direction, array('up', 'down'))) ? $direction : 'down';

	$sorter = new \backend\sorter("AND `is_active`='Y' AND `menu_context`='{$menu_context}'");
	$sorter->sort_table('query_menus', 'menu_id', $menu_id, $direction, 'sink_weight');
	#die('Sorting');

	# Assumes that the controller's name is the url's base name
	\common\stopper::url('menus-sort.php?context=' . $menu_context);
}
else
{
	# Show the page normally
	if($menu_context != '')
	{
		$entries = $menus->list_menus_for_sorting($menu_context);
		$smarty->assignByRef('menus', $entries);
	}
	else
	{
		\common\stopper::message('Please supply a context to list menus.');
	}
}
