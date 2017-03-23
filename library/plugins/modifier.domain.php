<?php
#namespace plugins;

/**
 * Gives the FULL URL of a page ID.
 * Assumed that only trusted source calls this file.
 *
 * @see |url, |www, |domain
 */
function smarty_modifier_domain($domain = "")
{
	$replaces = array(
		'#^.*?\://#is' => "",
		'/www./is' => "",
		'#/.*?$#' => "",
		'#/$#' => "",
	);

	$url = preg_replace(array_keys($replaces), array_values($replaces), $domain);

	return $url;
}
