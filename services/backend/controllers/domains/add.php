<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Add an entity in [ domains ]
 */

$domains = new \subdomain\domains();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('domains', 'array', array());

    # Immediately activate the record
    $data['is_active'] = 'Y';

    # When this record is added for the first time?
    $data['added_on'] = 'CURRENT_TIMESTAMP()';

    if ($domain_id = $domains->add($data, false)) {
        $messenger = new \common\messenger('success', 'The record has been added.');

        \common\stopper::url(\common\url::last_page('domains-list.php'));
        #\common\stopper::url('domains-add-successful.php');
        #\common\stopper::url('domains-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('domains-edit.php?id='.$domain_id);
    } else {
        $messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

        \common\stopper::url('domains-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('domains-direct-access-error.php');

    # Purpose of this code block is to make sure that the variable
    # gets all indices with blank data, to feed to ADD form.

    # A dynamic details about this record
    $details = array();

    # Validate it against the parameters in itself, plus those what we need.
    $details = $domains->validate('add', $details);
    $smarty->assign('domains', $details);
}

$smarty->assign('protection_code', $domains->code());
