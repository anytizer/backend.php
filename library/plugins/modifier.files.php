<?php
#namespace plugins;

/**
 * Counts number of files under a directory
 */
function smarty_modifier_files($directory = '/tmp')
{
	$total = 0;
	if(is_dir($directory))
	{
		$files = glob(realpath($directory) . '/*');
		$total = count($files);
	}

	return $total;
}
