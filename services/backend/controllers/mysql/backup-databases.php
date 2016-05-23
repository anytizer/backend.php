<?php
/**
 * Generates a script to backup ALL databases
 */

\common\headers::plain();

ob_start();

echo("@ECHO OFF
REM This allows to backup ALL databases in the system.
");
#REM Script generated on ".\common\tools::timestamp()."

$sql = "SHOW DATABASES;";
$db->query($sql);
while($database = $db->row(''))
{
	echo("
mysqldump -uroot -ptoor --routine {$database['Database']} > {$database['Database']}.dmp");
}

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . '/resources/database/databases.bat', $scripts);
