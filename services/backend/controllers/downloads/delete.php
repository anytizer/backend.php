<?php




/**
 * Delete an entity in [ downloads ]
 */

$downloads = new \subdomain\downloads();

# Assumes, ID always, in the GET parameter
if (($distribution_id = $variable->get('id', 'integer', 0)) && ($code = $variable->get('code', 'string', ""))) {
    if ($downloads->delete('inactivate', $distribution_id, $code)) {
        #\common\stopper::url('downloads-delete-successful.php');
        \common\stopper::url('downloads-list.php');
    } else {
        \common\stopper::url('downloads-delete-error.php');
    }
} else {
    \common\stopper::url('downloads-direct-access-error.php');
}
