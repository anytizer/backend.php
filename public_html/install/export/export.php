<?php
/**
 * Exports database tables of a subdomain.
 * This script NOT meant to export a subdomain into production environment.
 * Rather, it will just help ISOLATE a subdomain from the framework.
 * And, make the exported subdomain work as stand-alone application.
 * You will have to re-install the database, configure the subdomain, and test it
 *   before you export it into the production environment.
 * If the framework database was modified after exporting the subdomain,
 *   you may have to re-patch the new database, to make sure that it works well..
 */

# Load the name/password related configurations
require_once('../../inc.bootstrap.php');
require_once('../inc.config.php');
die('Is bootstrap loaded for library path?');

# Load the parent configurations
require_once($backend['paths']['__LIBRARY_PATH__'] . '/inc/inc.config.php');

/**
 * Source/Target username for ROOT level permissions
 * A temporary database will be created.
 * Data will be entered there.
 * This database will be backed up.
 * And finally this temporary database will be dropped out.
 *
 * @todo Use a common password
 */
$target = array(
    'username' => 'root',
    'password' => "",
    'hostname' => '192.168.1.1',
);

\common\headers::plain();

$db = new \common\mysql();

# New database to export the files into.
$database_name = 'db' . date('mdHis');
$timestamp = date('Y-m-d H:i:s');
$password = \common\tools::random_text(5);

# Export this Subdomain ID
# And the framework too.
$framework_subdomain_id = $config['framework_id'];
$current_database = MYSQL_DATABASENAME;

$subdomain_id = $variable->post('subdomain_id', 'integer', 0);
$framework_subdomain_id = 27;

# Verify that we have the subdomain available to export.
$subdomain_sql = "
SELECT
	subdomain_id,
	subdomain_name,
	is_protected
FROM `{$current_database}`.query_subdomains
WHERE
	subdomain_id={$subdomain_id}
;";
$subdomain = $db->row($subdomain_sql);

# The subdomain should exist first.
if (!isset($subdomain['subdomain_id'])) {
    \common\stopper::message('Invalid Subdomain ID: ' . $subdomain_id);
}

# Privacy control: Do not allow protected subdomains being exported.
if ($subdomain['is_protected'] == 'Y') {
    \common\stopper::message('Subdoimain is protected. Can not export ' . $subdomain['subdomain_name'] . '.');
}

# What will be the portion of the file name to save these scripts?
$subdomain['filename'] = preg_replace('/[^a-z0-9\.\-]/', "", $subdomain['subdomain_name']) . '.sql';

# Entire list of aliases and subdomains to be exported
$alias_sql = "
SELECT * FROM (
	SELECT
		subdomain_id
	FROM query_subdomains
	WHERE
		subdomain_id={$subdomain_id}
		OR alias_id={$subdomain_id}
	UNION
	SELECT
		alias_id
	FROM query_subdomains
	WHERE
		subdomain_id={$subdomain_id}
		OR alias_id={$subdomain_id}
) AS domains
WHERE
	subdomain_id!=0
;";
#die($alias_sql);
$db->query($alias_sql);
$aliases = $db->to_association('subdomain_id', 'subdomain_id');
$aliases = array_merge($aliases, array($framework_subdomain_id));
$subdomains_csv = implode(',', $aliases);
#print_r($subdomains_csv); die('...');

# Selectively export only the authorized system tables.
$sql = "
SELECT
	*
FROM `{$current_database}`.query_tables
WHERE
	is_active='Y'
	AND export_structure='Y'
ORDER BY
	table_name ASC
;";

$db->query($sql);

$sqls = array();
$sqls[] = "
############################################
## Subdomain ID: {$subdomain['subdomain_id']}
## Subdomain Name: {$subdomain['subdomain_name']}
## Server Timestamp: {$timestamp}
## Server Export Scripts    : install/export-scripts/{$subdomain['filename']}
## Subdomain Import Scripts : {$subdomain['subdomain_name']}/export-scripts.sql
############################################

# Create the database
DROP DATABASE IF EXISTS `{$database_name}`;
CREATE DATABASE `{$database_name}` CHARACTER SET utf8 COLLATE utf8_general_ci;

# Create a user for this DB
GRANT ALL ON `{$database_name}`.* TO '{$database_name}'@'localhost' IDENTIFIED BY '{$password}';
FLUSH PRIVILEGES;

################################
## Now, importing the tables  ##
################################";

while ($table = $db->row("")) {
    $sqls[] = "";
    $sqls[] = "## {$table['table_name']} ## {$table['table_comments']}";
    $sqls[] = "DROP TABLE IF EXISTS `{$database_name}`.`{$table['table_name']}`;";
    $sqls[] = "CREATE TABLE `{$database_name}`.`{$table['table_name']}` LIKE `{$current_database}`.`{$table['table_name']}`;";

    # For all newly created tables, truncate and reset their AUTO_INCREMENT status
    # It will also re-index a new table, internally.
    $sqls[] = "TRUNCATE `{$database_name}`.`{$table['table_name']}`;";

    if ($table['export_data'] == 'Y') {
        $sqls[] = "INSERT INTO `{$database_name}`.`{$table['table_name']}`";

        if (empty($table['export_query'])) {
            $sqls[] = "SELECT * FROM `{$current_database}`.`{$table['table_name']}`
WHERE
	# Specific subdomain
	subdomain_id={$subdomain_id}

	# The system framework database
	# OR subdomain_id={$framework_subdomain_id}

	# All related aliases
	OR subdomain_id IN ($subdomains_csv)

	# Global entries (they might have been added by mistake)
	# OR subdomain_id=0
;";
        } else {
            $sqls[] = "{$table['export_query']}";
        }
    } else {
        # $sqls[] = "# TRUNCATE `{$database_name}`.`{$table['table_name']}`;";
    }
}

# Do not keep it here. Backup/Export will not succeed.
#$sqls[] = "";
#$sqls[] ='# Finally leave the system clean.';
#$sqls[] = "DROP DATABASE IF EXISTS `{$database_name}`;";

$script_contents = implode("\r\n", $sqls);
file_put_contents(__APP_PATH__ . "/install/export-scripts/{$subdomain['filename']}", $script_contents);
echo $script_contents;

# Put the dump script within the subdomain files
$subdomain_name_sql = "
SELECT
	subdomain_name `name`,
	subdomain_id
FROM query_subdomains
WHERE
	subdomain_id={$subdomain_id}
;";
$subdomain = $db->row($subdomain_name_sql);
$subdomain['name'] = isset($subdomain['name']) ? $subdomain['name'] : "";
if ($subdomain['name']) {
    $__SUBDOMAIN_BASE__ = $framework->subdomain_base($subdomain['subdomain_id']);
    $export_sql_script = $__SUBDOMAIN_BASE__ . '/export-scripts.sql';
    #echo $export_sql_script;
    @file_put_contents($export_sql_script, $script_contents);
    @file_put_contents($__SUBDOMAIN_BASE__ . '/export-scripts.bat',
        "@ECHO OFF
REM Begin to create the exported subdomain database.
REM It will clone the system database and subdomain service database.

REM Database [{$database_name}] will be created.
mysql -u{$target['username']} -p{$target['password']} -h{$target['hostname']} < export-scripts.sql

REM Backup the final dump.
mysqldump --routine -u{$target['username']} -p{$target['password']} -h{$target['hostname']} {$database_name} > {$database_name}.dmp

REM If gzip is installed, compress the dump file.
gzip --keep --force -9 {$database_name}.dmp

REM Empty the database after taking a backup using a temp database
REM mysql -u{$target['username']} -p{$target['password']} -h{$target['hostname']} -s \"DROP DATABASE IF EXISTS {$database_name};\"

PAUSE
EXIT
"
    );
}
