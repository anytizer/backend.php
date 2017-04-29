<?php


# Created on: 2011-02-10 00:27:11 536

/**
 * Add an entity in [ subdomains ]
 */

$subdomains = new \subdomain\subdomains();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('subdomains', 'array', array());

    # File names will be based on this declaration. It should be safe to use.
    $data['subdomain_name'] = strtolower(preg_replace('/[^a-z0-9\_\-\.]+/is', "", $data['subdomain_name']));
    $data['subdomain_description'] = "";
    $data['begun_on'] = 'CURRENT_TIMESTAMP()';

    # Immediately activate the record
    $data['is_active'] = 'Y';

    # When this record is added for the first time?
    $data['added_on'] = 'CURRENT_TIMESTAMP()';
    $data['pointed_to'] = !empty($data['pointed_to']) ? str_replace('\\', '/', $data['pointed_to']) : "";

    if (empty($data['subdomain_ip'])) {
        # Try to auto-find the IP address of the subdomain name.
        $data['subdomain_ip'] = @gethostbyname($data['subdomain_name']);
    }

    if ($subdomain_id = $subdomains->add($data, false)) {
        $messenger = new \common\messenger('success', 'The record has been added.');

        \common\stopper::url(\common\url::last_page('subdomains-list.php'));
        #\common\stopper::url('subdomains-add-successful.php');
        #\common\stopper::url('subdomains-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('subdomains-edit.php?id='.$subdomain_id);
    } else {
        $messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

        \common\stopper::url('subdomains-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('subdomains-direct-access-error.php');

    # Purpose of this code block is to make sure that the variable
    # gets all indices with blank data, to feed to ADD form.

    # A dynamic details about this record
    $details = array();

    # Validate it against the parameters in itself, plus those what we need.
    $details = $subdomains->validate('add', $details);
    $smarty->assign('subdomains', $details);
}

$smarty->assign('protection_code', $subdomains->code());
