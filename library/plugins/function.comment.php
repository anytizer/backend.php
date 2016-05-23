<?php
#namespace plugins;

/**
 * Write something in the html output
 */
function smarty_function_comment($params = array(), &$smarty)
{
	$output = '';
	$params['type'] = isset($params['type']) ? $params['type'] : 'html';
	switch($params['type'])
	{
		case 'html':
			$output = isset($params['begin']) ? '<!--' : '-->';
			break;
		case 'normal':
			$output = isset($params['value']) ? $params['value'] : '';
			break;
		default:
	}

	return $output;
}
