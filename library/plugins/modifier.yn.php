<?php
#namespace plugins;

/**
 * Yes/No Icon
 *
 * @param string $yn
 * @param bool $use_full_url Begin URL with http://...?
 * @return string
 */
function smarty_modifier_yn($yn = 'N', $use_full_url = false)
{
	$image = ($yn == 'Y') ? 'tick' : 'cross';
	$alt = ($yn == 'Y') ? 'Yes' : 'No';
	$url = ($use_full_url != true) ? '.' : __URL__;

	return "<img alt=\"{$alt}\" title=\"\" src=\"{$url}/images/actions/{$image}.png\" />";
} # yn()
