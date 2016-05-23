<?php


# Created on: 2010-06-11 02:19:25 152

/**
 * Details of an entry in [ tables ]
 */

$table_id = $variable->get('id', 'integer', 0); # Some IDs
$code = $variable->get('code', 'string', ''); # Protection Code

$tables = new \subdomain\tables();

$tables_details = $tables->details($table_id, $code);
$smarty->assignByRef('tables', $tables_details);
