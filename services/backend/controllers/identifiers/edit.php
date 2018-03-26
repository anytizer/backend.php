<?php




/**
 * Edit an entity in [ identifiers ]
 */

$identifiers = new \subdomain\identifiers();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($identifier_id = $variable->post('identifier_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('identifiers', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';

    if ($success = $identifiers->edit(
        $data, # Posted data
        array(
            'identifier_id' => $identifier_id,
        ),
        $code, # Security code related to this entry
        $identifier_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/identifiers', 'images/identifiers', $record_id=$identifier_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('identifiers-list.php'));
        #\common\stopper::url('identifiers-edit-successful.php');
        #\common\stopper::url('identifiers-list.php');
    } else {
        \common\stopper::url('identifiers-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($identifier_id = $variable->get('id', 'integer', 0)) {
        $details = $identifiers->details($identifier_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('identifiers-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $identifiers->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('identifiers', $details);
    } else {
        # Really Bad...
        \common\stopper::url('identifiers-direct-access-error.php');
    }
}
