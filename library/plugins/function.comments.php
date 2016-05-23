<?php
#namespace plugins;

/**
 * Comments on/off
 */
function smarty_function_comments($params = array(), &$smarty)
{
	$comments = isset($params['close']) ? '-->' : '<!--';

	return $comments;
}
