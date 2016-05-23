<?php
# Compress the page's output. Include this file after inc.config.php
# And, allow certain headers to be manipulated even though there are some outputs.

# http://www.sitepoint.com/forums/showthread.php?p=4648257
# header('Content-Type: text/html'); # Do not predict content types now.
header('Content-Encoding: gzip');

$zlib_output_compression = ini_get('zlib.output_compression');
$zlib_output_handler = ini_get('zlib.output_handler');
if(in_array(strtoupper($zlib_output_compression), array('ON', '1', 'TRUE')) && $zlib_output_handler != '')
{
	# Compression is defined already.
	# Just begin the buffer.
	ob_start();
}
else
{
	ob_start('ob_gzhandler');
}