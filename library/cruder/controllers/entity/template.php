<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

# Empty Template File for various controllers

/**
 * This might be a controller only page and does not have anything to display.
 * Set the template to null.php for this file.
 * If this file is not used, it is okay to leave it here; safe.
 */

$__PK_NAME__ = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', '');

$__ENTITY__ = new \subdomain\__ENTITY__();

/**
 * Perform the action on __ENTITY__
 */
# Write a method to __ENTITY__ class and call it.
# Sanitization and data validation will be done inside the corresponding class/method.
# $__ENTITY__->some_action($__ENTITY___id, $code);

# Communicate with the next page via messenger.
# $messenger = new \common\messenger('notice', 'Some action has been taken on __ENTITY__.');

# This is probably a controller only page and does not have anything to display.
# Go back to he caller or listing page
\common\headers::back('__ENTITY__-list.php');
#\common\stopper::url(\common\url::last_page('__ENTITY__-list.php'));
