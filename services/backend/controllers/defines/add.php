<?php




/**
 * Add an entity in [ defines ]
 */

$defines = new \subdomain\defines();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('defines', 'array', array());
    $data['is_active'] = 'Y'; # Immediately activate the record
    $data['is_approved'] = 'Y';
    $data['auto_load'] = 'Y';
    $data['allow_edit'] = 'Y';
    $data['added_on'] = 'CURRENT_TIMESTAMP()'; # When this record is added?

    if ($define_id = $defines->add($data)) {
        #\common\stopper::url('defines-add-successful.php');
        #\common\stopper::url('defines-list.php');

        # Once successfully added, as the admin user to edit the data.
        \common\stopper::url('defines-edit.php?id=' . $define_id);
    } else {
        \common\stopper::url('defines-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    # \common\stopper::url('defines-direct-access-error.php');

    # A dynamic details about this record
    $details = array();

    # Validate it against the parameters in itself, plus those what we need.
    $details = $defines->validate('add', $details);
    $smarty->assign('defines', $details);
}

$smarty->assign('protection_code', $defines->code());
