<?php
#namespace plugins;

/**
 * Formats a number as bytes, based on size, and adds the appropriate suffix.
 * Adapted from number helper of Code Igniter.
 * @todo Replace to |tb, |gb, |kb, |mb, |bytes
 */
function smarty_modifier_byte_format($num)
{
	if($num >= 1000000000000)
	{
		$num = round($num / 1099511627776, 1);
		$unit = 'TB';
	}
	elseif($num >= 1000000000)
	{
		$num = round($num / 1073741824, 1);
		$unit = 'GB';
	}
	elseif($num >= 1000000)
	{
		$num = round($num / 1048576, 1);
		$unit = 'MB';
	}
	elseif($num >= 1000)
	{
		$num = round($num / 1024, 1);
		$unit = 'KB';
	}
	else
	{
		$unit = 'B';

		return number_format($num) . ' ' . $unit;
	}

	return number_format($num, 1) . ' ' . $unit;
}
