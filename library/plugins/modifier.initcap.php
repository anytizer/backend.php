<?php
#namespace plugins;

/**
 * Capitalizes all first letters in a word. A simple alias only.
 */
function smarty_modifier_initcap($string = '')
{
	$string = ucwords($string);

	return $string;
}
