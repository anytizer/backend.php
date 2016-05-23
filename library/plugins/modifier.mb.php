<?php
#namespace plugins;

/**
 * Filesize in Mega Bytes from Bytes
 */
function smarty_modifier_mb($bytes = 0)
{
	$bytes = (int)$bytes;
	if(!$bytes)
	{
		return $bytes;
	}

	$megabytes = $bytes / 1024 / 1024;
	$megabytes = number_format($megabytes, 2, '.', ',');

	return $megabytes;
}