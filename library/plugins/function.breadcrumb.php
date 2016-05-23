<?php
#namespace plugins;

/**
 * Make a breadcrumb navigator
 */
function smarty_function_breadcrumb($params = array(), &$smarty)
{
	$params['separator'] = !empty($params['separator']) ? $params['separator'] : ' &raquo; ';
	$bc = new \backend\breadcrumb();
	$breadcrumbs = $bc->generate(false); # No <LI>...</LI> tags

	return implode($params['separator'], $breadcrumbs);
} # breadcrumb()
