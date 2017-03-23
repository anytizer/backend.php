<?php
#namespace plugins;

/**
 * Yes/No Text
 */
function smarty_modifier_yesno($yn = 'N', $text_block = "")
{
	switch($text_block)
	{
		default:
			$text = ($yn == 'Y') ? 'Yes' : 'No';

			return $text;
	}
} # yesno()
