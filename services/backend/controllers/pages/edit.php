<?php


# Save process
if ($page_id = $variable->post('page-id', 'integer', 0)) {
    if ($pages->save($page_id)) {
        \common\stopper::url(\common\url::last_page('pages-list.php'));
        #\common\stopper::url('pages-edit-successful.php');
    } else {
        \common\stopper::url('pages-edit-error.php');
    }
}

$page_id = $variable->get('pi', 'integer', 0);
if (!$page_id) {
    # ID was not found; prgogramatic error or hack attemts by removing the URL details
    \common\stopper::url('pages-edit-error.php');
}

$details = $pages->list_details($page_id);
if (!$details) {
    # Data about the page was not available
    \common\stopper::url('pages-edit-error.php');
}

$smarty->assignByRef('details', $details);
