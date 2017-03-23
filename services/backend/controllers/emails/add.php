<?php


# Created on: 2011-03-23 11:38:46 911

/**
 * Add an entity in [ emails ]
 */

$emails = new \subdomain\emails();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('emails', 'array', array());

    # Immediately activate the record
    $data['is_active'] = 'Y';

    # When this record is added for the first time?
    $data['added_on'] = 'CURRENT_TIMESTAMP()';
    $data['subdomain_id'] = (int)$data['subdomain_id'];

    if ($email_id = $emails->add($data, false)) {
        # Send a welcome message (and ask to authenticate)
        #$emails->welcome_first($email_id);

        $messenger = new \common\messenger('success', 'The record has been added.');

        \common\stopper::url(\common\url::last_page('emails-list.php'));
        #\common\stopper::url('emails-add-successful.php');
        #\common\stopper::url('emails-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('emails-edit.php?id='.$email_id);
    } else {
        $messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

        \common\stopper::url('emails-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('emails-direct-access-error.php');

    # Purpose of this code block is to make sure that the variable
    # gets all indices with blank data, to feed to ADD form.

    # A dynamic details about this record
    $details = array();

    # Validate it against the parameters in itself, plus those what we need.
    $details = $emails->validate('add', $details);
    $smarty->assign('emails', $details);
}

$smarty->assign('protection_code', $emails->code());
