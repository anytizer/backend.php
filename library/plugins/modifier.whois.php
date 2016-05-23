<?php
#namespace plugins;

/**
 * Links an IP to whois records
 */
function smarty_modifier_whois($ip = '0.0.0.0', $server = '')
{
	# http://whois.arin.net/rest/ip/IPADDRESS
	# http://ws.arin.net/cgi-bin/whois.pl?queryinput=IPADDRESS

	if($ip == '' || $ip == '0.0.0.0')
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	$whois_link = "<a href=\"http://whois.arin.net/rest/ip/{$ip}\">{$ip}</a>";

	return $whois_link;
}
