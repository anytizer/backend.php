<?php


# Created on: 2011-03-18 13:20:47 198

/**
 * Add an entity in [ identifiers ]
 */

$identifiers = new \subdomain\identifiers();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('identifiers', 'array', array());

    # Immediately activate the record
    $data['is_active'] = 'Y';

    # When this record is added for the first time?
    $data['added_on'] = 'CURRENT_TIMESTAMP()';

    if ($identifier_id = $identifiers->add($data, false)) {
        $messenger = new \common\messenger('success', 'The record has been added.');

        \common\stopper::url(\common\url::last_page('identifiers-list.php'));
        #\common\stopper::url('identifiers-add-successful.php');
        #\common\stopper::url('identifiers-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('identifiers-edit.php?id='.$identifier_id);
    } else {
        $messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

        \common\stopper::url('identifiers-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('identifiers-direct-access-error.php');

    # Purpose of this code block is to make sure that the variable
    # gets all indices with blank data, to feed to ADD form.

    # A dynamic details about this record
    $details = array();

    # Validate it against the parameters in itself, plus those what we need.
    $details = $identifiers->validate('add', $details);
    $smarty->assign('identifiers', $details);
}

$smarty->assign('protection_code', $identifiers->code());
