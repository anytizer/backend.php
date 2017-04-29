<?php


# Created on: 2010-06-11 02:19:25 152

/**
 * Edit an entity in [ tables ]
 */

$tables = new \subdomain\tables();

# Handle Editing, when data is supplied
if ($variable->post('edit-action', 'string', "") && ($table_id = $variable->post('table_id', 'integer', 0))) {
    # Editing....
    $code = $variable->post('protection_code', 'string', "");
    $data = $variable->post('tables', 'array', array());
    # $data['modified_on']  = 'CURRENT_TIMESTAMP()'; 'UNIX_TIMESTAMP(CURRENT_TIMESTAMP())'; # Additional support, if any

    if ($success = $tables->edit(
        $data, # Posted data
        array(
            'table_id' => $table_id,
        ),
        $code, # Security code related to this entry
        $table_id
    )
    ) {
        #\common\stopper::url('tables-edit-successful.php');
        \common\stopper::url('tables-list.php');
    } else {
        \common\stopper::url('tables-edit-error.php');
    }
} else {
    /**
     * Otherwise, load the details of the entity before editing it.
     */
    if ($table_id = $variable->get('id', 'integer', 0)) {
        $details = $tables->details($table_id);

        /**
         * Build Smarty Variable with FULL details
         */
        $smarty->assign('tables', $details);
    } else {
        # Really Bad...
        \common\stopper::url('tables-direct-access-error.php');
    }
}
