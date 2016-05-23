<?php
#namespace plugins;

/**
 * Gives the Short URL with the link
 */
function smarty_modifier_shorturl($url = '')
{
	$short = preg_replace(
		array(
			'#^.*?\://#',
			'#www.#',
			'#/.*?$#',
			'#/$#',
		),
		array(
			'',
			'',
			'',
			'',
		),
		$url
	);

	return "<a href='{$url}'>{$short}</a>";
}
