<?php




/**
 * Edit an entity in [ emails ]
 */

$emails = new \subdomain\emails();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($email_id = $variable->post('email_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('emails', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';
    $data['subdomain_id'] = (int)$data['subdomain_id'];

    if ($success = $emails->edit(
        $data, # Posted data
        array(
            'email_id' => $email_id,
        ),
        $code, # Security code related to this entry
        $email_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/emails', 'images/emails', $record_id=$email_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('emails-list.php'));
        #\common\stopper::url('emails-edit-successful.php');
        #\common\stopper::url('emails-list.php');
    } else {
        \common\stopper::url('emails-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($email_id = $variable->get('id', 'integer', 0)) {
        $details = $emails->details($email_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('emails-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $emails->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('emails', $details);
    } else {
        # Really Bad...
        \common\stopper::url('emails-direct-access-error.php');
    }
}
