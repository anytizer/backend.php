<?php


# Created on: 2010-06-16 21:19:04 969

/**
 * Delete an entity in [ defines ]
 */

$defines = new \subdomain\defines();

# Assumes, ID always, in the GET parameter
if (($define_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($defines->delete('inactivate', $define_id, $code)) {
        #\common\stopper::url('defines-delete-successful.php');
        \common\stopper::url('defines-list.php');
    } else {
        \common\stopper::url('defines-delete-error.php');
    }
} else {
    \common\stopper::url('defines-direct-access-error.php');
}
