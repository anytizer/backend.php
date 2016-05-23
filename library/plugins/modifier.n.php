<?php
#namespace plugins;

/**
 * Whole Number (without the fraction)
 * @see Different than |nf plugin
 */
function smarty_modifier_n($number = 0)
{
	return number_format($number, 0, '.', ',');
}
