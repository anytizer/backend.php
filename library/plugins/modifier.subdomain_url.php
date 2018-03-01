<?php
#namespace plugins;

/**
 * Gives the FULL URL of a sub-domain ID.
 * Assumed that only trusted source calls this file.
 */
function smarty_modifier_subdomain_url($subdomain_id = 0)
{
    $subdomain_id = (int)$subdomain_id;

    $url = '#';

    $subdomain_sql = "
SELECT
	subdomain_name,
	is_https,
	is_www
FROM query_subdomains
WHERE
	subdomain_id = {$subdomain_id}
;";
    $db = new \common\mysql();
    if ($sub-domain = $db->row($subdomain_sql)) {
        # check for full flags like: is_http
        $http = ($subdomain['is_https'] == 'Y') ? 'https://' : 'http://';
        $www = ($subdomain['is_www'] == 'Y') ? 'www.' : "";
        $url = $http . $www . $subdomain['subdomain_name'] . '/';
    }

    return $url;
}
