<?php
#namespace plugins;

/**
 * Splits first name, middle name and last name
 */
function smarty_modifier_name($fullname = "", $position = 'first')
{
	$names = new \common\names();
	$name_words = $names->read_name($fullname);
	switch(strtoupper(trim($position)))
	{
		case 'F':
		case 'FIRST':
			$name_part = $name_words['F'];
			break;
		case 'M':
		case 'MIDDLE':
			$name_part = $name_words['M'];
			break;
		case 'L':
		case 'LAST':
		default:
			$name_part = $name_words['L'];
			break;
	}

	return $name_part;
} # name()

/**
 * Examples:
 * {assign var='fullname' value='Bimal'}
 * {assign var='fullname' value='Bimal Dev'}
 * {assign var='fullname' value='Bimal Dev Kumar'}
 * {assign var='fullname' value='Bimal Dev Kumar Pandey'}
 * First: {$fullname|name:'first'}<br />
 * Middle: {$fullname|name:'middle'}<br />
 * Last: {$fullname|name:'last'}
 */
