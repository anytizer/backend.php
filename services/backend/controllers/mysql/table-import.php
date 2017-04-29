<?php
/**
 * Helps to migrate tables from one database to other database.
 * Produces SQL Scripts to do so.
 */

\common\headers::plain();

#$from_db = 'register_prerana';
$from_db = 'source_database';

$to_db = 'target_database';

$copy_tables = array(
    'query_errors',
);

foreach ($copy_tables as $table) {
    $sqls = array(
        "CREATE TABLE `{$to_db}`.`{$table}` LIKE `{$from_db}`.`{$table}`;",
        "INSERT INTO `{$to_db}`.`{$table}` SELECT * FROM `{$from_db}`.`{$table}`;",
    );

    echo implode("\r\n", $sqls), "\r\n\r\n";
}