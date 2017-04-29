<?php
require_once('../inc.bootstrap.php');
require_once('../library/inc/inc.config.php');

/**
 * This file is meant to combine several javascript files into single javascript file.
 * The aim is to reduce overall HTTP requests on the server.
 * Usage Example:
 * <script type="text/javascript" src="js/index.php?js=ajax.js|validator.js"></script>
 */

header('Content-Type: text/javascript');
header('Content-Disposition: inline; filename="javascript.js"');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$js = $variable->get('js', 'string', 'javascript.js');
$js_files = explode('|', $js);
if (count($js_files)) {
    foreach ($js_files as $j => $js_file) {
        if (file_exists($js_file)) {
            readfile($js_file);
        }
    }
    exit(0);
}
?>
/**
* PLEASE DO NOT MODIFY THE ORIGINAL JAVASCRIPT FILES.
*/