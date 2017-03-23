<?php
/**
 * Edit all lines that apply.
 */
$backend = array(
    'paths' => array(),
    'urls' => array(),
    'database' => array(
        'HOSTNAME' => "",
        'USERNAME' => "",
        'PASSWORD' => "",
        'DATABASE' => "",
    ),

    # Verification of Backend Configuration
    'signatures' => array(
        'paths' => null,
        'urls' => null,
        'database' => null,
        'signatures' => null,
    ),
);

# 8 files
# global $

# 16 files
# path to realpath(../public_html)
# @todo Remove the usage
# DO NOT EDIT
$backend['paths']['__APP_PATH__'] = realpath(dirname(__FILE__) . '/..');

# 15 files; resolved
# Where is the library/ directory
# EDIT, point the path correctly
$backend['paths']['__LIBRARY_PATH__'] = $backend['paths']['__APP_PATH__'] . '/library';

# 13 files
# @todo Remove using: library/tmp = 1 files: install/index.php
$backend['paths']['__TEMP_PATH__'] = $backend['paths']['__APP_PATH__'] . '/tmp';

# 5 files # backend
# @todo Remove the usage
# DO NOT EDIT
$backend['paths']['__SERVICES_PATH__'] = $backend['paths']['__APP_PATH__'] . '/services';

# 31 files, Subdomain Root, Dynamic;
# @todo Calculate
# Proposed only
$backend['paths']['__SUBDOMAIN_BASE__'] = $backend['paths']['__SERVICES_PATH__'] . '/localhost';

# 6 files
$backend['urls']['__URL__'] = "";

# Generate signatures
foreach ($backend as $index => $value) {
    $backend['signatures'][$index] = md5(implode("", array_keys($backend[$index])));
}
#print_r($backend); die();
