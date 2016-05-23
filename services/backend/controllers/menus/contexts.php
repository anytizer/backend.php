<?php


$data_sql = "
SELECT
	menu_context mc,
	COUNT(menu_id) counter
FROM query_menus
WHERE
	is_active='Y'
GROUP BY
	menu_context
ORDER BY
	menu_context
;";

$data = $db->arrays($data_sql);
$smarty->assignByRef('contexts', $data);
