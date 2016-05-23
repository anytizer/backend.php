<?php
/**
 * Load the dashboard menus from the database.
 * It is tightly bound with CSS/Sprites and the HTML class names.
 */
$dashboard_sql = "
SELECT
	menu_text AS `text`,
	menu_link `link`,
	html_title `title`,
	html_class `sprite`
FROM query_menus
WHERE
	menu_context='system:dashboard'
	AND is_active='Y'
ORDER BY
	sink_weight
;";

$db->query($dashboard_sql);
$dashboards = $db->to_array();
$smarty->assignByRef('dashboards', $dashboards);
