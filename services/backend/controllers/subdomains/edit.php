<?php




/**
 * Edit an entity in [ subdomains ]
 */

$subdomains = new \subdomain\subdomains();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($subdomain_id = $variable->post('subdomain_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('subdomains', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';

    if (empty($data['subdomain_ip'])) {
        # Try to auto-find the IP address of the sub-domain name.
        $data['subdomain_ip'] = @gethostbyname($data['subdomain_name']);
    }

    # Linux file format compatibility
    $data['pointed_to'] = str_replace('\\', '/', $data['pointed_to']);
    $data['pointed_to'] = preg_replace('/\/$/is', "", $data['pointed_to']);

    if ($success = $subdomains->edit(
        $data, # Posted data
        array(
            'subdomain_id' => $subdomain_id,
        ),
        $code, # Security code related to this entry
        $subdomain_id
    )
    ) {
        # Something about the image uploaders as a patch
        # $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/subdomains', 'images/subdomains', $record_id=$subdomain_id);

        $messenger = new \common\messenger('success', 'The record has been modified.');

        \common\stopper::url(\common\url::last_page('subdomains-list.php'));
        #\common\stopper::url('subdomains-edit-successful.php');
        #\common\stopper::url('subdomains-list.php');
    } else {
        \common\stopper::url('subdomains-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($subdomain_id = $variable->get('id', 'integer', 0)) {
        $details = $subdomains->details($subdomain_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('subdomains-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $subdomains->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('subdomains', $details);
    } else {
        # Really Bad...
        \common\stopper::url('subdomains-direct-access-error.php');
    }
}
