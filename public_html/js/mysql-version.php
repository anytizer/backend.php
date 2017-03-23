<?php
/**
 * Purpose: To send the subdomain specific javascript files.
 * This allows to put the css packs within the subdomain service only.
 * Uses the power of HTTP Headers.
 * @todo Find out the library path
 */

require_once('../inc.bootstrap.php');
require_once($backend['paths']['__LIBRARY_PATH__'].'/inc/inc.config.php');

$page = $variable->get('page', 'string', 'javascript.js');

# Safety
$page = preg_replace('/[^a-z0-9\-\_\.\/]/is', "", $page);
$page = str_replace('..', "", $page);
$page = str_replace('//', '/', $page);

$file = realpath(__SUBDOMAIN_BASE__ . "/js/{$page}");

if(is_file($file))
{
	# Send headers
	\common\headers::cache();
	\common\headers::headers_by_extension($file);

	# Output the file
	readfile($file);
}
else
{
	# Nothing to do...
	# Make a server log
	# Send the browser at least some javascript CSS contents
	echo "/** No Javascripts **/";
}