<?php
#namespace plugins;

/**
 * Number format with 2 digits decimals. Eg. Currency.
 * @see Different than |n plugin
 */
function smarty_modifier_nf($number = 0)
{
	$nf = number_format($number, 2, '.', ',');

	return $nf;
}
