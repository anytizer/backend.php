<?php
/**
 * Clones MySQL tables to different database as views.
 */

$subdomains = array(
	27, # Framework
	# 228, 229, # Study Nepal Application
	222, 223, # uniQrewards
);
$prefixes = array(
	'query', # Framework
	'reward', # Application
);
$target_database = 'framework_projects';

# END of configurations.
# Do NOT modify codes below this line.


$system_database = MYSQL_DATABASENAME;

\common\headers::plain();

echo "
# CREATE DATABASE `{$target_database}` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `{$target_database}`;
";

$sql = "SHOW FULL TABLES FROM `{$system_database}` WHERE table_type = 'BASE TABLE';";
$db->query($sql);
while($table = $db->row(""))
{
	$table = $table["Tables_in_{$system_database}"];
	if(!preg_match('/^(' . implode('|', $prefixes) . ')_/', $table))
	{
		continue;
	}
	$subdomains_list = implode(',', $subdomains);
	echo("
DROP VIEW IF EXISTS `{$target_database}`.`{$table}`;
CREATE VIEW `{$target_database}`.`{$table}` AS SELECT * FROM `{$system_database}`.`{$table}` WHERE subdomain_id IN ($subdomains_list);
");
}
die("#Completed - ({$system_database})#");
