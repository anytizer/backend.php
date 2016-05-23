<?php
#namespace plugins;

/**
 * Filesize in Kilo Bytes from Bytes
 */
function smarty_modifier_kb($bytes = 0)
{
	$bytes = (int)$bytes;
	if(!$bytes)
	{
		return $bytes;
	}

	$kilobytes = $bytes / 1024;
	$kilobytes = number_format($kilobytes, 2, '.', ',');

	return $kilobytes;
}
