<?php
#namespace plugins;

/**
 * Safely converts a word into url paramaeter
 */
function smarty_modifier_urlword($words = '')
{
	$safe_word = urlencode(htmlentities($words));

	return $safe_word;
}
