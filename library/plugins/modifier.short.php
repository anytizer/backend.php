<?php
#namespace plugins;

require_once(dirname(__FILE__) . '/modifier.partial.php');

/**
 * Truncates long text in the middle and eats it up to genreate sort text
 * @todo Remove this plugin
 * @see |partial
 */
function smarty_modifier_short($text = "", $acceptable_length = 10)
{
	return smarty_modifier_partial($text, $acceptable_length);
}
