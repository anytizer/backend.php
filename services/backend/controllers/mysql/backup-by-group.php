<?php
/**
 * Helps to backup the database into different groups.
 * Each group is identified according to its prefix word.
 * Feature alike grouping in PHPMyAdmin's database lists.
 */

\common\headers::plain();

$tables = $db->tables();

$filter = array();

foreach($tables as $table)
{
	# Double underscores are invalid.
	# Those beginning with an underscore are invalid.
	# These ending with an underscore are invalid.
	# Those not having an underscore are invalid.

	if(preg_match('/^\_/', $table))
	{
		continue;
	}

	if(preg_match('/\_\_/', $table))
	{
		continue;
	}

	if(preg_match('/\_$/', $table))
	{
		continue;
	}

	if(!preg_match('/\_/', $table))
	{
		continue;
	}

	# key_table_names...
	$names = explode('_', $table);

	$key = $names[0];

	unset($names[0]);
	$name = implode('_', $names);

	#$filter[$key][] = $name;
	$filter[$key][] = $table;
}

#print_r($filter);
$database_name = MYSQL_DATABASENAME;
$backup_lines = array();
foreach($filter as $key => $names)
{
	# [SPACE] separated values
	$name_ssv = implode(' ', $names);

	$backup_lines[] = "mysqldump -uroot -ptoor {$database_name} {$name_ssv} > {$key}.grp";
}

$backup_commands = implode("\r\n", $backup_lines);
file_put_contents(__APP_PATH__ . '/resources/database/groups.bat', $backup_commands);

echo $backup_commands;
