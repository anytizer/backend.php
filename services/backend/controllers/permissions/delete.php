<?php


# Created on: 2011-03-29 23:48:23 316

/**
 * Delete an entity in [ permissions ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('permissions-list.php');

$permissions = new \subdomain\permissions();

# Assumes, ID always, in the GET parameter
if (($crud_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($permissions->delete('inactivate', $crud_id, $code)) {
        $messenger = new \common\messenger('warning', 'The record has been deleted.');

        #\common\stopper::url('permissions-delete-successful.php');
        \common\stopper::url('permissions-list.php');
    } else {
        $messenger = new \common\messenger('error', 'The record has NOT been deleted.');

        \common\stopper::url('permissions-delete-error.php');
    }
} else {
    \common\stopper::url('permissions-direct-access-error.php');
}
