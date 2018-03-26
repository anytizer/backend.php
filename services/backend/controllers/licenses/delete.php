<?php




/**
 * Delete an entity in [ licenses ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('licenses-list.php');

$licenses = new \subdomain\licenses();

# Assumes, ID always, in the GET parameter
if (($license_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($licenses->delete('inactivate', $license_id, $code)) {
        $messenger = new \common\messenger('warning', 'The record has been deleted.');

        #\common\stopper::url('licenses-delete-successful.php');
        \common\stopper::url('licenses-list.php');
    } else {
        $messenger = new \common\messenger('error', 'The record has NOT been deleted.');

        \common\stopper::url('licenses-delete-error.php');
    }
} else {
    \common\stopper::url('licenses-direct-access-error.php');
}
