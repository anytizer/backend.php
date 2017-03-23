<?php
/**
 * Scripts to generate each table's backup
 */

\common\headers::plain();

ob_start();

echo("
@ECHO OFF
REM Allows to backup all tables individually
");
#REM Script generated on ".\common\tools::timestamp()."

$database = MYSQL_DATABASENAME;

# Write your custom username/password to dump the data
$username = 'root';
$password = 'toor';

$sql = "SHOW FULL TABLES FROM `{$database}` WHERE table_type = 'BASE TABLE';";
$db->query($sql);
while($table = $db->row(""))
{
	$table = $table["Tables_in_{$database}"];
	echo "\r\nmysqldump --lock-tables -u{$username} -p{$password} {$database} {$table} > {$table}.dmp";

	# --lock-tables
	# --routine
	# --no-data
	# --complete-insert
	# --no-create-info
	# --compact

	# 1. SQL Sscripts only, with CREATE TABLE ...
	# 2. Dump the Data only
}

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . '/resources/database/tables.bat', $scripts);
