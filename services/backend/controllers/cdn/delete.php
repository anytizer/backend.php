<?php


# Created on: 2010-11-15 13:36:42 243

/**
 * Delete an entity in [ cdn ]
 */

$cdn = new \subdomain\cdn();

# Assumes, ID always, in the GET parameter
if (($cdn_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($cdn->delete('inactivate', $cdn_id, $code)) {
        #\common\stopper::url('cdn-delete-successful.php');
        \common\stopper::url('cdn-list.php');
    } else {
        \common\stopper::url('cdn-delete-error.php');
    }
} else {
    \common\stopper::url('cdn-direct-access-error.php');
}
