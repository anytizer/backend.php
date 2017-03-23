<?php
#namespace plugins;

/**
 * @package Plugins
 */
/**
 * Privately called to capitalize randomly selected letters
 */
function smarty_modifier_color_garble_capital($letter = "")
{
	if(mt_rand(0, 9) % 3 == 0)
	{
		$letter = strtoupper($letter);
	}

	return $letter;
}

/**
 * Privately called to colorate a single letter
 */
function smarty_modifier_color_garble_colors($letter = "")
{
	$colors = array('FF0000', '009900', '0000FF');

	#if(mt_rand(0, 9)%3==0)
	{
		$color = $colors[mt_rand(0, count($colors) - 1)];
		$letter = "<span style='color:#{$color};'>{$letter}</span>";
	}

	return $letter;
}

/**
 * Colorates a text of any length
 */
function smarty_modifier_color($text = "", $capitals = false, $colors = false)
{

	$letters = $text;
	#$letters = strtolower($letters); # Optional, before treating the text
	$letters = str_split($letters);

	if($capitals === true)
	{
		$letters = array_map('smarty_modifier_color_garble_capital', $letters);
	}

	if($colors === true)
	{
		$letters = array_map('smarty_modifier_color_garble_colors', $letters);
	}

	return implode("", $letters);
}
