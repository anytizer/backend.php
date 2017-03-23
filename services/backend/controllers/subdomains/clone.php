<?php
$subdomain_id = $variable->get('id', 'integer', 0);

$current_database = 'backend';
$t = $db->arrays("SHOW TABLES LIKE 'query_%';");
#print_r($t); die();

$ignore = array(
	'query_session',
	'query_subdomains',
	'query_table',
	'query_templates',
	'query_cdn',
	'query_databases',
	'query_tables',
);


#$subdomain_id=140; # Remove this line, as it comes from user parameters
$clone_to_subdomain_id = 'yyy'; # 170;

/**
 * Let us hope that is are only one primary key in one table.
 */
function pk_name($database_name = "", $table_name = "")
{
	static $pkname_db;
	if(!$pkname_db)
	{
		$pkname_db = new \common\mysql();
	}

	$pk_name_sql = "
SELECT
	COLUMN_NAME
FROM information_schema.COLUMNS
WHERE
	TABLE_SCHEMA='{$database_name}'
	AND TABLE_NAME='{$table_name}'
	# AND COLUMN_KEY='PRI'
	
	AND EXTRA='auto_increment'
;";
	#echo $pk_name_sql;
	$name = $pkname_db->row($pk_name_sql);
	if(!$name)
	{
		$name = array('COLUMN_NAME' => '<strong style="text-decoration:line-through; color:#0FF;">xxx_id</strong>');
	}
	#print_r($name);

	#echo "\r\n", $table_name, ', ', $name['COLUMN_NAME'];
	#echo "UPDATE query_tables SET primary_key='{$name['COLUMN_NAME']}' WHERE table_name='{$table_name}';", "\r\n";
	return $name['COLUMN_NAME'];
}

#echo pk_name('backend', 'query_pages');
#echo pk_name('backend', 'query_subdomains');
#die('...');

$counter = 0;
$change_sqls = array();

$clone_sqls = array();
$clone_sqls[] = 'DROP DATABASE IF EXISTS `<strong>xxx</strong>`;';
$clone_sqls[] = 'CREATE DATABASE `<strong>xxx</strong>` CHARACTER SET utf8 COLLATE utf8_general_ci;';
$clone_sqls[] = '&nbsp;'; # Grouping

foreach($t as $id => $ts)
{
	$table = implode(', ', $ts);
	$tables[] = $table;

	$change_sqls[] = "UPDATE `{$table}` SET subdomain_id=<strong>xxx</strong> WHERE subdomain_id={$subdomain_id};";

	# Find and update PK ID
	#SELECT MAX(page_id) id FROM query_pages;
	++$counter;
	# Nullable

	if(in_array($table, $ignore))
	{
		continue;
	}

	# avoid system tables:
	# mange conflicts in global tables with uniqe keys: query_uploads

	$pk_name = pk_name($current_database, $table);;
	$clone_sqls[] = "DROP TABLE IF EXISTS `<strong>xxx</strong>`.`{$table}`;"; # We recrete the database itself. So, no need to drop the individual tables.
	$clone_sqls[] = "CREATE TABLE `<strong>xxx</strong>`.`{$table}` LIKE `<em>{$current_database}</em>`.`{$table}`;";
	$clone_sqls[] = "ALTER TABLE `<strong>xxx</strong>`.`{$table}` CHANGE `{$pk_name}` `{$pk_name}` INT(10) UNSIGNED NULL COMMENT 'Temporary primary key', DROP PRIMARY KEY;";
	$clone_sqls[] = "ALTER TABLE `<strong>xxx</strong>`.`{$table}` ENGINE = MYISAM;";
	$clone_sqls[] = "INSERT INTO  `<strong>xxx</strong>`.`{$table}` SELECT * FROM `<em>{$current_database}</em>`.`{$table}` WHERE subdomain_id=<strong style='color:#FF0000;'>{$subdomain_id}</strong>;";
	$clone_sqls[] = "UPDATE `<strong>xxx</strong>`.`{$table}` SET `{$pk_name}`=NULL, subdomain_id=<strong style='color:#0000FF;'>{$clone_to_subdomain_id}</strong>;";
	$clone_sqls[] = "INSERT INTO `<em>{$current_database}</em>`.`{$table}` SELECT * FROM  `<strong>xxx</strong>`.`{$table}`;";
	$clone_sqls[] = '&nbsp;'; # Grouping
}

# Cleanup the database now
$clone_sqls[] = "DROP DATABASE IF EXISTS `<strong>xxx</strong>`";

$smarty->assign('update', $change_sqls);
$smarty->assign('clone', $clone_sqls);
