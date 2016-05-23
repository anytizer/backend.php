<?php
#namespace plugins;

/**
 * Ternary Operator in Smarty Templates
 * @todo Give usage example for ternary modifier plugin
 * @todo List out where this modifier is used in
 *
 * @param string $original_value
 * @param string $compare_to_value
 * @param string $yes_value Print this value when the comparison is true.
 * @param string $no_value Print this value when the comparison is NOT true.
 *
 * @return string
 *
 * @url http://www.ninjacipher.com/2007/11/24/smarty-ternary-modifier/
 * @url http://www.smarty.net/forums/viewtopic.php?t=14622&highlight=ternary
 * @url http://www.smarty.net/forums/viewtopic.php?t=2044&highlight=ternary
 * @url http://www.smarty.net/forums/viewtopic.php?p=54700
 */
function smarty_modifier_ternary($original_value = '', $compare_to_value = '', $yes_value = '', $no_value = '')
{
	$value = ($original_value === $compare_to_value) ? $yes_value : $no_value;
	return $value;
}
