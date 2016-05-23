<?php
#namespace plugins;

/**
 * Converts Windows file name into Linux types.
 */
function smarty_modifier_filename($filename = '')
{
	$filename = str_replace('\\', '/', $filename);

	# Not necessary to check the existence of the filename for now.

	return $filename;
}
