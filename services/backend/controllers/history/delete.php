<?php


# Created on: 2010-12-27 11:38:12 391

/**
 * Delete an entity in [ history ]
 */

$history = new \subdomain\history();

# Assumes, ID always, in the GET parameter
if (($history_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($history->delete('inactivate', $history_id, $code)) {
        #\common\stopper::url('history-delete-successful.php');
        \common\stopper::url('history-list.php');
    } else {
        \common\stopper::url('history-delete-error.php');
    }
} else {
    \common\stopper::url('history-direct-access-error.php');
}
