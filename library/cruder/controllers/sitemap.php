<?php
$sitemap_sql = "
# Sitemap of all the available pages in this subdomain
SELECT
	`qp`.`page_name` `n`,
	`qp`.`content_title` `t`,
	`qp`.`meta_description` `md`
FROM `query_pages` `qp`
INNER JOIN `query_subdomains` `qm` ON
	`qm`.`subdomain_id` = `qp`.`subdomain_id`
	AND `qm`.`subdomain_name`='{$_SERVER['SERVER_NAME']}'
	AND `qp`.`is_active`='Y'
	AND `qp`.`in_sitemap`='Y'
	AND `qp`.`is_system`='N'
ORDER BY
	`qp`.`sink_weight`,
	`qp`.`page_name`
# For pagination
# LIMIT 0, 999
;";
$db->query($sitemap_sql);
$sitemap = $db->to_array();
$smarty->assign('sitemap', $sitemap);
