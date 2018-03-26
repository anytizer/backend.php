<?php




/**
 * Edit an entity in [ history ]
 */

$history = new \subdomain\history();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($history_id = $variable->post('history_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('history', 'array', array());

    # Mark when this data was modified last time.
    $data['modified_on'] = 'CURRENT_TIMESTAMP()';

    if ($success = $history->edit(
        $data, # Posted data
        array(
            'history_id' => $history_id,
        ),
        $code, # Security code related to this entry
        $history_id
    )
    ) {
        \common\stopper::url(\common\url::last_page('history-list.php'));
        #\common\stopper::url('history-edit-successful.php');
        #\common\stopper::url('history-list.php');
    } else {
        \common\stopper::url('history-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($history_id = $variable->get('id', 'integer', 0)) {
        $details = $history->details($history_id);
        if (!$details) {
            # Data about this entity was not available
            \common\stopper::url('history-edit-error.php');
        }
        # Purpose of this code block is to make sure that the variable
        # gets all indices with blank data, to feed to EDIT form.
        $details = $history->validate('edit', $details);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('history', $details);
    } else {
        # Really Bad...
        \common\stopper::url('history-direct-access-error.php');
    }
}
