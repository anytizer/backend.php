<?php
#namespace plugins;

/**
 * Make a readable word or words from a single word
 */
function smarty_modifier_readable($word = '')
{
	$words = preg_split('/[^a-z]/', $word);
	$words = array_filter($words);

	$words = array_map('strtolower', $words);
	$words = array_map('ucfirst', $words);

	return implode(' ', $words);
}
