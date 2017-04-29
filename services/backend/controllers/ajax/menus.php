<?php
# Ajax output, Show a list of menus by name.
# Hints while adding a new menu.

$menus = new \backend\menus();
$context = $variable->get('context', 'string', "");
$context = \common\tools::safe_sql_word($context);
#print_r($_GET);

$menus_text_sql = "
SELECT
	menu_text t
FROM query_menus
WHERE
	menu_context='{$context}'
	AND menu_link!=''
	AND is_active='Y'
ORDER BY
	sink_weight ASC,
	menu_text
;";
$texts = $db->values('t', $menus_text_sql);
echo implode(' | ', $texts);

# For NO zero-sized reply
echo "<!-- Just completed producing menus under context: {$context} -->";
