<?php
/**
 * Generates a fresh copy of Framework Tables.
 */

$validator = new database_structure_validator();

$datestamp = date('Y-m-d H:i:s');

/**
 * Readable table name
 */
function processed_name($name = "")
{
    $names = preg_split('/[^a-z0-9]+/i', $name);
    $names = array_map('ucfirst', $names);

    return implode(' ', $names);
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Table Records</title>
    <link href="css/mysql-table-structures.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <h1>Core table structures - exported to make the installer.</h1>
    <?php
    #$export_list_sql="SHOW TABLES LIKE 'query_%';";
    # Rather, use a pre-defined list of tables only.
    $export_list_sql = "
SELECT
	*
FROM query_tables
WHERE
	is_active='Y'
ORDER BY
	table_name ASC
;";
    $db->query($export_list_sql);
    $tables = $db->to_array();
    #print_r($tables);

    $counter = 0;
    foreach ($tables as $table) {
        ++$counter;

        $sql = "SHOW CREATE TABLE `{$table['table_name']}`;";
        $body = $db->row($sql);

        # Do not use the AUTO_INCREMENT flag.
        $body['Create Table'] = preg_replace('/ AUTO_INCREMENT=[\d]+ /i', ' ', $body['Create Table']);

        echo "
<p># {$counter}. Database scripts for: <strong>{$table['table_name']}</strong></p>
<pre>{$body['Create Table']};</pre>
";

        $processed_table_name = processed_name($table['table_name']);
        $table_comments = $validator->table_comments($table['table_name']);

        # The considered sub-domain or core framework's sub-domain ID
        $subdomain_id = 27; # Replace this with your sub-domain to export the data.
        $framework_subdomain_id = 27;

        $csv_file_name = str_replace('\\', '/', __APP_PATH__ . '/install/sql-scripts/_csv/' . $table['table_name'] . '.csv');
        #echo "<p>{$csv_file_name}</p>";

        # Make sure that the CSV filename is available to create new.
        # Hence by removing it if exists.
        if (is_file($csv_file_name)) {
            @unlink($csv_file_name);
        }

        # Do not export DATA, if not requested.
        if ($table['export_data'] == 'Y') {
            /*
            * @todo: Implement a CUSTOM Query here
            * @todo: Server location should be passed. So, the database and the system should run on same server.
            */
            $export_csv_sql = "
SELECT
	*
INTO OUTFILE '{$csv_file_name}'
FIELDS ESCAPED BY '\\\\' TERMINATED BY ',' ENCLOSED BY '\"'
LINES TERMINATED BY '\\r\\n'
FROM `{$table['table_name']}`
WHERE
	# Intended sub-domain ID
	subdomain_id={$subdomain_id}

	# The framework and its alias
	OR subdomain_id={$framework_subdomain_id}
	#OR alias_id={$framework_subdomain_id}

	# The global things.
	# Warning: This might have been done by mistake as well.
	OR subdomain_id=0
;";
            #die($export_csv_sql);
            # Export the Framework's registered pages
            $db->query($export_csv_sql);
        } else {
            # Make the file blank, without any data
            file_put_contents($csv_file_name, '#');
        }

# Published date is removed, not to affect the tables in SVN being complained as new change.
# * Published on: {$datestamp}
        $information_text = "/**
* Skeleton of [{$processed_table_name}: {$table['table_name']}]
* {$table_comments}
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @package Backend Framework
*/

";
        # Update the scripts for SVN's use Or for installers
        $structure_file = __APP_PATH__ . '/install/sql-scripts/_struct/' . $table['table_name'] . '.struct';
        file_put_contents($structure_file, $information_text);
        file_put_contents($structure_file, $body['Create Table'], FILE_APPEND);
        file_put_contents($structure_file, ";\r\n\r\n", FILE_APPEND);

        $import_csv_sql = "
TRUNCATE `{$table['table_name']}`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/{$table['table_name']}.csv'
INTO TABLE `{$table['table_name']}`
FIELDS ESCAPED BY '\\\\' TERMINATED BY ',' ENCLOSED BY '\"'
LINES TERMINATED BY '\\r\\n';

";
        $dat_file = __APP_PATH__ . '/install/sql-scripts/_dat/' . $table['table_name'] . '.dat';
        file_put_contents($dat_file, $import_csv_sql);
    }
    ?>
</div>
</body>
</html>
