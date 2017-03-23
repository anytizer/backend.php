<?php
$sitemap_sql = "
# Sitemap for our urls
SELECT
	qp.page_name n,
	qp.content_title t
FROM query_pages qp
INNER JOIN query_subdomains qm ON
	qm.subdomain_id = qp.subdomain_id
	AND qm.subdomain_name='{$_SERVER['SERVER_NAME']}'
	AND qp.is_active='Y'
	AND qp.in_sitemap='Y'
	AND qp.is_system='N'
WHERE
	qp.content_title!=""
;";
$db->query($sitemap_sql);
$sitemap = $db->to_array();
$smarty->assignByRef('sitemap', $sitemap);
