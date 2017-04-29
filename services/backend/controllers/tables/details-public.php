<?php


# Created on: 2010-06-11 02:19:25 152

/**
 * Details of an entry in [ tables ]
 */

$table_id = $variable->get('id', 'integer', 0); # Some IDs
$code = $variable->get('code', 'string', ""); # Protection Code

if (!$table_id) {
    \common\stopper::url('tables-direct-access-error.php');
}

$tables = new \subdomain\tables();

$tables_details = $tables->details($table_id, $code);

if (!$tables_details) {
    \common\stopper::url('tables-direct-access-error.php');
}

$smarty->assignByRef('tables', $tables_details);
