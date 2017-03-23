<?php
/**
 * Modifies the storage engine of all tables in the database
 */

\common\headers::plain();

$engine = $variable->get('engine', 'string', 'InnoDB');
$engine = ($engine == 'InnoDB') ? $engine : 'MyISAM';

ob_start();

echo("
# This script resets the storage engine.
");
#REM Script generated on ".\common\tools::timestamp()."

$database = MYSQL_DATABASENAME;

$sql = "SHOW FULL TABLES FROM `{$database}` WHERE table_type = 'BASE TABLE';";
$db->query($sql);
while($table = $db->row(""))
{
	$table = $table["Tables_in_{$database}"];
	echo "
ALTER TABLE `{$table}` ENGINE = {$engine};";
	#echo "\r\n", "ALTER TABLE `{$table}` ENGINE = MyISAM;";
}

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . '/resources/database/convert-' . strtolower($engine) . '.bat', $scripts);
