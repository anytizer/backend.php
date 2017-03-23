<?php


# Created on: 2011-04-06 14:42:31 485

/**
 * Delete an entity in [ messages ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('messages-list.php');

$messages = new \subdomain\messages();

# Assumes, ID always, in the GET parameter
if (($message_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($messages->delete('inactivate', $message_id, $code)) {
        $messenger = new \common\messenger('warning', 'The record has been deleted.');

        #\common\stopper::url('messages-delete-successful.php');
        \common\stopper::url('messages-list.php');
    } else {
        $messenger = new \common\messenger('error', 'The record has NOT been deleted.');

        \common\stopper::url('messages-delete-error.php');
    }
} else {
    \common\stopper::url('messages-direct-access-error.php');
}
