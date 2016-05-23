<?php
/**
 * Scripts to generate each table's backup
 */

\common\headers::plain();

ob_start();

echo("@ECHO OFF
REM This allows to restore all tables back to the database.
ECHO Warning - You will lost the existing data.
PAUSE
");
#REM Script generated on ".\common\tools::timestamp()."

$database = MYSQL_DATABASENAME;

$sql = "SHOW FULL TABLES FROM `{$database}` WHERE table_type = 'BASE TABLE';";
$db->query($sql);
while($table = $db->row(''))
{
	$table = $table["Tables_in_{$database}"];
	echo("
mysql -uroot -ptoor {$database} < {$table}.dmp");
}

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . '/resources/database/restore.bat', $scripts);
