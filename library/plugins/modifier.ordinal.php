<?php
#namespace plugins;

# http://www.smarty.net/forums/viewtopic.php?p=58046

/**
 * Sends an ordinality of a number
 * Prints out the number too.
 */
function smarty_modifier_ordinal($number = 0, $html = false, $class = 'ordinal')
{
	$o = new \common\ordinal();
	$output = '';
	if($html === true)
	{
		if($class)
		{
			$output = "<sup class='{$class}'>{$o->ordinality($number)}</sup>";
		}
		else
		{
			$output = "<sup>{$o->ordinality($number)}</sup>";
		}
	}
	else
	{
		$output = $o->ordinality($number);
	}

	return $number . $output;
}
