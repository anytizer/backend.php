<?php
#namespace plugins;

/**
 * Read the GET parameters to build the HREF link
 * Filter flags can be separated by pipe (|) or comma (,)
 *
 * @example url.php?{get filter='page|id'}
 */
function smarty_function_get($params = array(), &$smarty)
{
	$g = new \common\get($_GET);

	$params['filter'] = !empty($params['filter']) ? $params['filter'] : '';
	$filters = preg_split('/[^a-z0-9\_]+/is', $params['filter']);
	foreach($filters as $f => $filter)
	{
		$g->no_get($filter);
	}

	$get = $g->url();

	return $get;
}
