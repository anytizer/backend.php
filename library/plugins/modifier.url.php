<?php
#namespace plugins;

/**
 * Gives the FULL URL of a page ID.
 * Assumed that only trusted source calls this file.
 *
 * @see |url, |www, |domain
 */
function smarty_modifier_url($page_id = 0)
{
    $page_id = (int)$page_id;

    $url = '#';

    $page_sql = "
SELECT
	qs.is_https,
	qs.is_www,
	qs.subdomain_name `domain`,
	qs.subdomain_port `port`,
	qp.page_name `page`
FROM query_pages qp
INNER JOIN query_subdomains qs ON
	qs.subdomain_id = qp.subdomain_id
	AND qp.page_id={$page_id}
;";
    $db = new \common\mysql();
    if ($page = $db->row($page_sql)) {
        # check for full flags like: is_http
        $http = ($page['is_https'] == 'Y') ? 'https://' : 'http://';
        $www = ($page['is_www'] == 'Y') ? 'www.' : "";
        $url = "{$http}{$www}{$page['domain']}:{$page['port']}/{$page['page']}";
    }

    return $url;
}
