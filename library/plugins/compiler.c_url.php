<?php
#namespace plugins;

/**
 * Useful in making a website have COMPLETE URL
 */
function smarty_compiler_c_url($params = array(), &$smarty)
{
	$url = '/public_html'; # The default, local root URL

	# It should not have a trailing / because:
	# Other applications might have used it already.
	# A subdirectory should begin with a slash, and end without a slash.
	$sub_directory = (__LIVE__ === true) ? '' : '/backend/backend/public_html';

	$url_sql = "
SELECT
	is_https,
	is_www,
	subdomain_name `domain`,
	subdomain_port `port`
FROM query_subdomains
WHERE
	subdomain_name = '{$_SERVER['SERVER_NAME']}'
;";
	$db = new \common\mysql();
	if($page = $db->row($url_sql))
	{
		$http = ($page['is_https'] == 'Y') ? 'https://' : 'http://';
		$www = ($page['is_www'] == 'Y') ? 'www.' : '';
		$url = "{$http}{$www}{$page['domain']}:{$page['port']}{$sub_directory}";
	}
	else
	{
		# The server dedicates a root location for this framework.
		$url = '/';
	}

	return $url;
}
