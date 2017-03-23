<?php
/**
 * Scripts to generate each table's backup
 */

\common\headers::plain();

ob_start();

echo "
@ECHO OFF
REM Allows to backup framework specific tables individually
";
#REM Script generated on ".\common\tools::timestamp()."

#$database = "db0210150954"; # MYSQL_DATABASENAME;
$database = MYSQL_DATABASENAME;

# Write your custom username/password to dump the data
$username = "root";
$password = "toor";
$tablename_prefix = "query"; # query | rgaps
$backup_options = "--skip-extended-insert --compact --complete-insert --skip-quote-names --no-create-db --no-create-info --no-set-names --lock-tables";

$skip_list = array(
    "query_cdn",
    "query_code_generators",
    "query_config",
    "query_contacts",
    "query_cruded",
    "query_development_history",
    "query_distributions",
    "query_downloads",
    "query_dropdowns",
    "query_licenses",
    "query_logger",
    "query_messages",
    "query_server",
    "query_sessions",
    "query_subdomains_categories",
    "query_subdomains_status",
    "query_tables",
    "query_uploads",
    "query_users_groups",
);
#print_r($skip_list);

$sql = "SHOW TABLES FROM {$database} LIKE '{$tablename_prefix}%';";
$db->query($sql);
while ($table = $db->row("")) {
    #print_r($table); die("Tables_in_{$database} ({$tablename_prefix}%)");
    # fart: Replaces \' with "" for MSSQL compatibility
    $table = $table["Tables_in_{$database} ({$tablename_prefix}%)"];


    if (in_array($table, $skip_list)) {
        continue;
    } # Follow the skip rules

    # Special warnings
    # Some tables like query_sessions do not have identity column, and setting those flags should be skipped.

    echo "
ECHO TRUNCATE TABLE {$table}; > {$table}.dmp
ECHO SET IDENTITY_INSERT {$table} ON; >> {$table}.dmp
mysqldump {$backup_options} -u{$username} -p{$password} {$database} {$table} >> {$table}.dmp
ECHO SET IDENTITY_INSERT {$table} OFF; >> {$table}.dmp
..\\fart --quiet {$table}.dmp \' ""
..\\fart --quiet {$table}.dmp \\\" \"
REM ..\\fart --quiet {$table}.dmp \\r\\n
REM ..\\fart --quiet {$table}.dmp \\t
";

	# --lock-tables
	# --routine
	# --no-data
	# --complete-insert
	# --no-create-info
	# --compact

	# 1. SQL Scripts only, with CREATE TABLE ...
	# 2. Dump the Data only
}

echo "
COPY /Y /B *.dmp backup.sql
PAUSE";

$scripts = ob_get_flush();
file_put_contents(__APP_PATH__ . "/resources/database/mssql/mssql-{$tablename_prefix}.bat", $scripts);
