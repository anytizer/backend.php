<?php
#namespace plugins;

/**
 * Search for a CSS external media file.
 * CSS files neeed to be in [css] directory.
 * @example {css href='style.css'}
 * @example {css href='style.css|my.css'}
 * @example {css base=='../css' 'style.css}
 * @example {css base='../css' href='1.css|2.css|3.css'}
 */
function smarty_function_css($params = array(), &$smarty)
{
	$css = '';
	$css_es = array();
	$params['href'] = !empty($params['href']) ? $params['href'] : '';
	$params['base'] = !empty($params['base']) ? $params['base'] : 'css/custom'; # give a link to FULL URL
	if($params['href'])
	{
		# Were there multiple files requested?
		$hrefs = explode('|', $params['href']);
		foreach($hrefs as $i => $href)
		{
			$css_es[] = "<link href=\"{$params['base']}/{$href}\" rel=\"stylesheet\" type=\"text/css\" />";
		}
	}
	#$css_es[]="<link href='combine.php?files={$params['href']}' rel='stylesheet' type='text/css' />";
	$css = implode("\n", $css_es);

	return $css;
} # css()
