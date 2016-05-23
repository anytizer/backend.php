<?php
#namespace plugins;

/**
 * A short clone of HTMLSpamFilter
 * @see HTMLSpamFilter
 */
function smarty_modifier_safe($string = '')
{
	$trim_at = 2;
	$boring_comments_html = '';
	$return = '';
	for($i = 0; $i < strlen($string); $i++)
	{
		$return .= '&#x' . bin2hex(substr($string, $i, 1)) . ';';
		if($trim_at > 0 && $i % $trim_at == ($trim_at - 1))
		{
			$boring_comments_html = '<!--' . mt_rand(10, 99) . '-->';
			$return .= $boring_comments_html;
		}
	}

	return $return;
} # safe()
