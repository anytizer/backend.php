<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Edit an entity in [ domains ]
 */

$domains = new \subdomain\domains();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($domain_id = $variable->post('domain_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('domains', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';

    if ($success = $domains->edit(
        $data, # Posted data
        array(
            'domain_id' => $domain_id,
        ),
        $code, # Security code related to this entry
        $domain_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/domains', 'images/domains', $record_id=$domain_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('domains-list.php'));
        #\common\stopper::url('domains-edit-successful.php');
        #\common\stopper::url('domains-list.php');
    } else {
        \common\stopper::url('domains-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($domain_id = $variable->get('id', 'integer', 0)) {
        $details = $domains->details($domain_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('domains-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $domains->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('domains', $details);
    } else {
        # Really Bad...
        \common\stopper::url('domains-direct-access-error.php');
    }
}
