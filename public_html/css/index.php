<?php
require_once('../inc.bootstrap.php');
require_once('../library/inc/inc.config.php');

/**
 * This file is meant to combine several css files into single css file.
 * The aim is to reduce overall HTTP requests on the server.
 * Usage Example:
 * <link href="css/index.php?css=general.css|recent.css" rel="stylesheet" type="text/css" />
 */

header('Content-Type: text/css');
header('Content-Disposition: inline; filename="style.css"');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$css = $variable->get('css', 'string', 'style.css');
$css_files = explode('|', $css);
if (count($css_files)) {
    foreach ($css_files as $c => $css_file) {
        if (file_exists($css_file)) {
            echo "/** File: {$css_file} - Starts **/", file_get_contents($css_file), "/** File: {$css_file} - Ends **/";
        }
    }
    exit(0);
}
?>
/**
* PLEASE DO NOT MODIFY THE ORIGINAL CSS FILES.
*/