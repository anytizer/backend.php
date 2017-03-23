<?php


# Created on: 2011-02-09 23:25:11 836

/**
 * Delete an entity in [ cms ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('cms-list.php');

$cms = new \subdomain\cms();

# Assumes, ID always, in the GET parameter
if (($page_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($cms->delete('inactivate', $page_id, $code)) {
        $messenger = new \common\messenger('warning', 'The record has been deleted.');

        #\common\stopper::url('cms-delete-successful.php');
        \common\stopper::url('cms-list.php');
    } else {
        $messenger = new \common\messenger('error', 'The record has NOT been deleted.');

        \common\stopper::url('cms-delete-error.php');
    }
} else {
    \common\stopper::url('cms-direct-access-error.php');
}
