<?php
/**
 * Purpose: To send the subdomain specific css files.
 * This allows to put the css packs within the subdomain service only.
 * Uses the power of HTTP Headers.
 * @todo Find out where is the Library Directory is
 */
require_once('../inc.bootstrap.php');
require_once($backend['paths']['__LIBRARY_PATH__'] . '/inc/inc.config.php');

$page = $variable->get('page', 'string', 'style.css');

# Safety of the css names
$page = preg_replace('/[^a-z0-9\-\_\.\/\{\}]/is', "", $page);
$page = str_replace('..', "", $page);
$page = str_replace('//', '/', $page);

$css_file_found = false;

$css_files = array(
    'base' => realpath(__SUBDOMAIN_BASE__ . "/templates/css/{$page}"),
);
foreach ($css_files as $css_file) {
    if (is_file($css_file)) {
        # Send CSS headers
        \common\headers::cache();
        \common\headers::headers_by_extension($css_file);
        readfile($css_file);

        $css_file_found = true;
        break;
    }
}

if (!$css_file_found) {
    # Nothing to do...
    # Make a server log
    # Send the browser at least some expected CSS contents
    echo "/** No CSS in {$page} **/";
}
