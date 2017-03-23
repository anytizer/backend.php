<?php
#namespace plugins;

/**
 * Finds out a variable
 * Similar to ||magical plugin
 */
function smarty_modifier_find($index = "", $default = 0)
{
	$variable = new \common\variable();

	return $variable->find($index, $default);
}
