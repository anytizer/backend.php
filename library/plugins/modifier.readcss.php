<?php
#namespace plugins;

/**
 * Reads out specific css files within the subdomains.
 * Reason: They might need to be embeded within the template file.
 * Usage: {'filename.css'|readcss}
 */
function smarty_modifier_readcss($css_file = "")
{
	$css_body = "";
	if(defined('__SUBDOMAIN_BASE__'))
	{
		# We will access the files within their subdomains only
		$full_path = __SUBDOMAIN_BASE__ . '/templates/css/' . $css_file;
		if($full_path)
		{
			if(is_file($full_path))
			{
				$css_body = readfile($full_path);
			}
		}
	}

	return $css_body;
}
