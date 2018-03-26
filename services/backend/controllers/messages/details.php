<?php




/**
 * Details of an entry in [ messages ]
 */

$message_id = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if (!$message_id) {
    # Page was loaded without the ID parameter
    \common\stopper::url('messages-direct-access-error.php?context=identity');
} else {
    $messages = new \subdomain\messages();

    # Try to load the details
    if ($messages_details = $messages->details($message_id, $code)) {
        # We aim to reach here only.
        $smarty->assignByRef('messages', $messages_details);
    } else {
        # Record not found
        \common\stopper::url('messages-direct-access-error.php?context=data');
    }
}
