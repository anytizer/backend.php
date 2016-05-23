<?php


$sitemap_sql = "
# Sitemap for our urls
SELECT
	page_name n,
	content_title t
FROM query_pages p
WHERE
	p.is_active='Y'
	AND p.in_sitemap='Y'
	AND p.is_system='N'
;";
$db->query($sitemap_sql);
$sitemap = $db->to_array();
$smarty->assignByRef('sitemap', $sitemap);

\common\headers::xml();
