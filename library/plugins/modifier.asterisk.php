<?php
#namespace plugins;

/**
 * Prints a red colored asterisk mark (*) if a value matches some condition
 * @example {'?'|asterisk:'?':2}
 * @example {$flag|asterisk:'Y':2}
 *
 * @see |stars modifier.stars.php
 */
function smarty_modifier_asterisk($value = "", $conditional_value = "", $stars = 1)
{
	$html = "";
	$stars = str_pad("", (int)$stars, '*', STR_PAD_LEFT);

	if(!empty($value) && $value == $conditional_value)
	{
		$html = "<span style='color:#FF0000; font-weight:bold;'>{$stars}</span>";
	}

	return $html;
}
