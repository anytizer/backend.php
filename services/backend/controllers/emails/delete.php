<?php




/**
 * Delete an entity in [ emails ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('emails-list.php');

$emails = new \subdomain\emails();

# Assumes, ID always, in the GET parameter
if (($email_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($emails->delete('inactivate', $email_id, $code)) {
        $messenger = new \common\messenger('warning', 'The record has been deleted.');

        #\common\stopper::url('emails-delete-successful.php');
        \common\stopper::url('emails-list.php');
    } else {
        $messenger = new \common\messenger('error', 'The record has NOT been deleted.');

        \common\stopper::url('emails-delete-error.php');
    }
} else {
    \common\stopper::url('emails-direct-access-error.php');
}
