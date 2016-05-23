<?php
/**
 * Purpose: To send the subdomain specific js files.
 * This allows to put the image packs within the subdomain service only.
 * Uses the power of HTTP Headers.
 * @todo Find out the path of library
 */

require_once('../inc.bootstrap.php');
require_once($backend['paths']['__LIBRARY_PATH__'].'/inc/inc.config.php');

$page = $variable->get('page', 'string', 'blank.png');

# Safety of the image name
$page = preg_replace('/[^a-z0-9\-\_\.\/\{\}]/is', '', $page);
$page = str_replace('..', '', $page);
$page = str_replace('//', '/', $page);

$image_file_found = false;

$image_files = array(
	'base' => realpath(__SUBDOMAIN_BASE__ . "/templates/images/{$page}"),
);

foreach ($image_files as $image_file) {
	if (is_file($image_file)) {
		# Send image headers
		\common\headers::cache();
		\common\headers::headers_by_extension($image_file);
		readfile($image_file);

		$image_file_found = true;
		break;
	}
}

if (!$image_file_found) {
	# Nothing to do...
	# Make a server log
	# Send the browser at least some expected CSS contents
	#\common\headers::error404();
	#echo "/** No Image in {$page} **/";

	#Or, rather send a blank file: Do not frustrate the client
	$info['extension'] = isset($info['extension']) ? strtolower($info['extension']) : 'jpg';
	switch ($info['extension']) {
		case 'jpg':
		case 'png':
		case 'gif':
			\common\headers::headers_by_extension($info['extension']);
			#$blank = 'blank.'.$info['extension'];
			$blank = 'default.' . $info['extension'];
			readfile(dirname(__FILE__) . '/' . $blank);
			break;
		default:
			\common\headers::error404();
			\common\stopper::message('The file you are searching is not available here.');
	}
}
