<?php




/**
 * Edit an entity in [ messages ]
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

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($message_id = $variable->post('message_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('messages', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';

    if ($success = $messages->edit(
        $data, # Posted data
        array(
            'message_id' => $message_id,
        ),
        $code, # Security code related to this entry
        $message_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/messages', 'images/messages', $record_id=$message_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('messages-list.php'));
        #\common\stopper::url('messages-edit-successful.php');
        #\common\stopper::url('messages-list.php');
    } else {
        \common\stopper::url('messages-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($message_id = $variable->get('id', 'integer', 0)) {
        $details = $messages->details($message_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('messages-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $messages->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('messages', $details);
    } else {
        # Really Bad...
        \common\stopper::url('messages-direct-access-error.php');
    }
}

$messenger = new \common\messenger();
