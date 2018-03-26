<?php




/**
 * Edit an entity in [ superfish ]
 */

$superfish = new \subdomain\superfish();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($menu_id = $variable->post('menu_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('superfish', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';
    $data['parent_id'] = isset($data['parent_id']) ? (int)$data['parent_id'] : 0;

    if ($success = $superfish->edit(
        $data, # Posted data
        array(
            'menu_id' => $menu_id,
        ),
        $code, # Security code related to this entry
        $menu_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/superfish', 'images/superfish', $record_id=$menu_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('superfish-list.php'));
        #\common\stopper::url('superfish-edit-successful.php');
        #\common\stopper::url('superfish-list.php');
    } else {
        \common\stopper::url('superfish-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($menu_id = $variable->get('id', 'integer', 0)) {
        $details = $superfish->details($menu_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('superfish-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $superfish->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('superfish', $details);
    } else {
        # Really Bad...
        \common\stopper::url('superfish-direct-access-error.php');
    }
}
