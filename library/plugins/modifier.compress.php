<?php
#namespace plugins;

/**
 * Tigtens or compresses a text and makes it appear as a signle word
 * alias of |tighten
 */
function smarty_modifier_compress($text = '')
{
	$text = preg_replace('/[^a-z0-9]+/is', '', $text);

	return strtoupper($text);
}
