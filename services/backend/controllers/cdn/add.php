<?php


# Created on: 2010-11-15 13:36:42 243

/**
 * Add an entity in [ cdn ]
 */

$cdn = new \subdomain\cdn();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('cdn', 'array', array());
    $data['is_active'] = 'Y'; # Immediately activate the record
    # $data['added_on'] = 'CURRENT_TIMESTAMP()'; # When this record is added?

    if ($cdn_id = $cdn->add($data)) {
        \common\stopper::url(\common\url::last_page('cdn-list.php'));
        #\common\stopper::url('cdn-add-successful.php');
        #\common\stopper::url('cdn-list.php');

        # Once successfully added, as the admin user to edit the data.
        #\common\stopper::url('cdn-edit.php?id='.$cdn_id);
    } else {
        \common\stopper::url('cdn-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('cdn-direct-access-error.php');
}

$smarty->assign('protection_code', $cdn->code());
