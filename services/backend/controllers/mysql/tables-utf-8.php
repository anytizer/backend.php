<?php
/**
 * Scripts to change the tables to UTF-8 Character Set
 */

\common\headers::plain();

ob_start();

echo("
@ECHO OFF
REM This allows to change all tables into UTF-8.
");
#REM Script generated on ".\common\tools::timestamp()."

$database = MYSQL_DATABASENAME;

$sql = "SHOW FULL TABLES FROM `{$database}` WHERE table_type = 'BASE TABLE';";
$db->query($sql);
while($table = $db->row(''))
{
	$table = $table["Tables_in_{$database}"];
	echo("
ALTER TABLE `{$table}` CHARSET=utf8 COLLATE=utf8_general_ci;");
}

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . '/resources/database/utf-8.bat', $scripts);
