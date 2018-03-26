<?php




/**
 * Add an entity in [ messages ]
 */

$status = array(
    'error' => 'error',
    'success' => 'success',
    'warning' => 'warning',
    'notice' => 'notice',
    'info' => 'info',
    'caution' => 'caution',
    'message' => 'message',
);
$smarty->assign('status', $status);

$messages = new \subdomain\messages();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('messages', 'array', array());

    # Immediately activate the record
    $data['is_active'] = 'Y';

    # When this record is added for the first time?
    $data['added_on'] = 'CURRENT_TIMESTAMP()';
    $data['message_code'] = \common\tools::timestamp();

    if ($message_id = $messages->add($data, false)) {
        # Send a welcome message (and ask to authenticate)
        #$messages->welcome_first($message_id);

        $messenger = new \common\messenger('success', 'The record has been added.');

        \common\stopper::url(\common\url::last_page('messages-list.php'));
        #\common\stopper::url('messages-add-successful.php');
        #\common\stopper::url('messages-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('messages-edit.php?id='.$message_id);
    } else {
        $messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

        $_SESSION['attempt_messages'] = $data;
        \common\stopper::url('messages-add.php');
        #\common\stopper::url('messages-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('messages-direct-access-error.php');

    # Purpose of this code block is to make sure that the variable
    # gets all indices with blank data, to feed to ADD form.

    # A dynamic details about this record
    $details = array();

    if (isset($_SESSION['attempt_messages'])) {
        $details = $_SESSION['attempt_messages'];
        unset($_SESSION['attempt_messages']);
    }

    # Validate it against the parameters in itself, plus those what we need.
    $details = $messages->validate('add', $details);
    $smarty->assign('messages', $details);
}

$smarty->assign('protection_code', $messages->code());
