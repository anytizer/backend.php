<?php
/**
 * Reverse of cloning
 * Merges an externally built subdomain project into a parent.
 *
 * @todo Auto calculate the list of subdomains needed to move.
 * @todo Make more dynamic merger
 */

$subdomain_id = $variable->get('id', 'integer', 0);

$current_database = 'backend';
$t = $db->arrays("SHOW TABLES LIKE 'query_%';");

$ignore = array(
	'query_ignore', # a non existing table for a sample only.
);

#$subdomain_id=140; # Remove this line, as it comes from user parameters
$externals_database = 'slingride'; # 'XXXY';
$subdomain_id_old = '28'; # If different ID, use it.
#$clone_to_subdomain_id = 'yyy'; # 170;
$clone_to_subdomain_id = 'YYYY'; # '125, 126, 142'; # 170; # Including the aliases if they might have data
#$clone_to_subdomain_id = 'xxx, yyy, zzz'; # 170; # Including the aliases

/**
 * Let us hope that is are only one primary key in one table.
 */
function pk_name($database_name = '', $table_name = '')
{
	#static $pkname_db;
	#if(!$pkname_db) $pkname_db = new \common\mysql();
	$pkname_db = new \common\mysql();

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
		#$name = array('COLUMN_NAME' => '<strong style="text-decoration:line-through; color:#0FF;">xxx_id</strong>');
		$name = 'xxx_id';
	}
	#print_r($name);

	#echo "\r\n", $table_name, ', ', $name['COLUMN_NAME'];
	#echo "UPDATE query_tables SET primary_key='{$name['COLUMN_NAME']}' WHERE table_name='{$table_name}';", "\r\n";
	return "<strong style='color:#0FF;'>{$name['COLUMN_NAME']}</strong>";
	#return $name['COLUMN_NAME'];
}

#echo pk_name('backend', 'query_pages');
#echo pk_name('backend', 'query_subdomains');

$counter = 0;
$change_sqls = array();

$merge_sqls = array();

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
	# COMMENT 'Temp. primary key'
	$merge_sqls[] = "ALTER TABLE `<strong style='color:#FF0000;'>{$externals_database}</strong>`.`{$table}` CHANGE `{$pk_name}` `{$pk_name}` INT(10) UNSIGNED NULL, DROP PRIMARY KEY;";
	$merge_sqls[] = "UPDATE `<strong>{$externals_database}</strong>`.`{$table}` SET `{$pk_name}`=NULL;";
	$merge_sqls[] = "DELETE FROM `<em>{$externals_database}</em>`.`{$table}` WHERE `subdomain_id` NOT IN ({$subdomain_id_old});";
	$merge_sqls[] = "UPDATE `<em>{$externals_database}</em>`.`{$table}` SET `subdomain_id`={$clone_to_subdomain_id};";
	$merge_sqls[] = "DELETE FROM `<em>{$current_database}</em>`.`{$table}` WHERE subdomain_id IN (<strong style='color:#0000FF;'>{$clone_to_subdomain_id}</strong>);";
	$merge_sqls[] = "# <strong style='color:#FF0000;'>SELECT</strong> * FROM `<em>{$externals_database}</em>`.`{$table}` WHERE subdomain_id IN (<strong style='color:#0000FF;'>{$subdomain_id_old}</strong>);";
	$merge_sqls[] = "# <strong style='color:#FF0000;'>SELECT</strong> * FROM `<em>{$current_database}</em>`.`{$table}` WHERE subdomain_id IN (<strong style='color:#0000FF;'>{$clone_to_subdomain_id}</strong>);";

	# List out all columns in source table
	$externals_columns = array();
	$result = mysql_query("SHOW COLUMNS FROM `{$externals_database}`.`{$table}`;");
	if($result)
	{
		if(mysql_num_rows($result) > 0)
		{
			while($row = mysql_fetch_assoc($result))
			{
				$externals_columns[] = "`{$row['Field']}`";
				/*
				Array
				(
					[Field] => article_id
					[Type] => int(10) unsigned
					[Null] => NO
					[Key] => PRI
					[Default] =>
					[Extra] => auto_increment
				)
				*/
			}
		}
	}
	$externals_columns = implode(', ', $externals_columns);

	# Separate system might have less
	$merge_sqls[] = "<strong style='color:#009900;'>INSERT IGNORE INTO</strong> `<em>{$current_database}</em>`.`{$table}` (<em>{$externals_columns}</em>) <strong style='color:#009900;'>SELECT</strong> <em>{$externals_columns}</em> FROM  `<strong>{$externals_database}</strong>`.`{$table}` WHERE subdomain_id IN (<strong style='color:#0000FF;'>{$clone_to_subdomain_id}</strong>);";
	$merge_sqls[] = '&nbsp;'; # Grouping

	#break;
}

$smarty->assign('update', $change_sqls);
$smarty->assign('merge', $merge_sqls);
