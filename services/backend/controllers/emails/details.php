<?php




/**
 * Details of an entry in [ emails ]
 */

$email_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if (!$email_id) {
    # Page was loaded without the ID parameter
    \common\stopper::url('emails-direct-access-error.php?context=identity');
} else {
    $emails = new \subdomain\emails();

    # Try to load the details
    if ($emails_details = $emails->details($email_id, $code)) {
        # We aim to reach here only.
        $smarty->assignByRef('emails', $emails_details);
    } else {
        # Record not found
        \common\stopper::url('emails-direct-access-error.php?context=data');
    }
}
