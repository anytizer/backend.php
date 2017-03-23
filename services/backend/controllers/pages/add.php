<?php


$pages = new \subdoamin\pages();

if ($variable->post('add-action', 'string', "")) {
    # Posted Data: Apply security
    $data = $variable->post('page', 'array', array());
    $data['is_active'] = 'Y';
    $data['added_on'] = 'CURRENT_TIMESTAMP()';

    if ($page_id = $pages->add($data)) {
        #\common\stopper::url(\common\url::last_page('pages-list.php'));
        \common\stopper::url('pages-list.php');
    } else {
        \common\stopper::url('page-add-error.php');
    }
} else {
    $details = array();
    $pages->validate('add', $details);

    $smarty->assign('details', $details);
}

$smarty->assign('protection_code', $pages->code());
