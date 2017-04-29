<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Details of an entry in [ smtp ]
 */

$smtp_id = $variable->get('id', 'integer', 0); # Some IDs
$code = $variable->get('code', 'string', ""); # Protection Code

$smtp = new \subdomain\smtp();

# Try to load the details
if ($smtp_details = $smtp->details($smtp_id, $code)) {
    $smarty->assignByRef('smtp', $smtp_details);
} else {
    # Record not found
    \common\stopper::url('smtp-direct-access-error.php');
}
