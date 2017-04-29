<?php
$subdomain_id = $variable->get('id', 'integer', 0);

$t = $db->arrays("SHOW TABLES LIKE 'query_%';");

$change_sqls = array();
$change_sqls[] = "SET @SUBDOMAIN_ID='{$subdomain_id}'; -- Change it.";
foreach ($t as $id => $ts) {
    $table = implode(', ', $ts);
    $tables[] = $table;

    $change_sqls[] = "UPDATE `{$table}` SET subdomain_id=@SUBDOMAIN_ID WHERE subdomain_id={$subdomain_id};";
}

$smarty->assign('sqls', $change_sqls);
