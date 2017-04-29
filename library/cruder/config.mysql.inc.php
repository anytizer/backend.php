<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * MySQL Database access configurations
 */

/**
 * Database Connection parameters.
 * It can hold records about multiple database servers.
 */
$dbinfo = array(); # Resets any older settings, if any.

/**
 * Define which server to use.
 * This is a default/dynamic name of the server
 */
$dbinfo['dbindex'] = $_SERVER['SERVER_NAME'];

#######################################################################
####################[ !THE ONLY MODIFIABLE CODES! ]####################
#######################################################################

/**
 * For each possible servers, define the connection parameters.
 * It increases the portability of the system across various servers.
 */
switch ($dbinfo['dbindex']) {
    case '__SUBDOMAIN_NAME__':
    case 'localhost':
    default:
        $dbinfo[$dbinfo['dbindex']]['host'] = 'MYSQLHOSTNAME';
        $dbinfo[$dbinfo['dbindex']]['dbuser'] = 'MYSQLUSERNAME';
        $dbinfo[$dbinfo['dbindex']]['dbpassword'] = 'MYSQLPASSWORD';
        $dbinfo[$dbinfo['dbindex']]['database'] = 'MYSQLDATABASE';
        # CREATE DATABASE `MYSQLDATABASE` CHARACTER SET utf8 COLLATE utf8_general_ci;
        # GRANT ALL ON `MYSQLDATABASE`.* TO 'MYSQLUSERNAME'@'MYSQLHOSTNAME' IDENTIFIED BY 'MYSQLPASSWORD';
        break;
}

$MYSQL_CONNECTION = mysqli_connect(
    $dbinfo[$dbinfo['dbindex']]['host'],
    $dbinfo[$dbinfo['dbindex']]['dbuser'],
    $dbinfo[$dbinfo['dbindex']]['dbpassword'],
    $dbinfo[$dbinfo['dbindex']]['database']
) or \common\stopper::message("Cannot connect to the database <strong>{$dbinfo[$dbinfo['dbindex']]['database']}</strong> on {$dbinfo[$dbinfo['dbindex']]['host']}.");

/**
 * Based on the actual database index, make an actual database connection.
 * Everything will be used as a global value.
 * @todo Replace MYSQL_DATABASENAME with variable only through out the application scripts.
 */
define('MYSQL_DATABASENAME', $dbinfo[$dbinfo['dbindex']]['database']);

/**
 * Bring the time zones together.
 * Parameter example: +5:45.
 */
$timezone = (defined('__TIMEZONE_NUMERIC__') && preg_match('/^[\+|\-][\d]{1,2}\:[\d]{1,2}$/is', __TIMEZONE_NUMERIC__)) ? __TIMEZONE_NUMERIC__ : '+5:45';
mysqli_query($MYSQL_CONNECTION, "SET time_zone = '{$timezone}';");

/**
 * Support Unicode by default.
 */
mysqli_query($MYSQL_CONNECTION, "SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
mysqli_query($MYSQL_CONNECTION, "SET CHARACTER_SET_CONNECTION=utf8;");
mysqli_query($MYSQL_CONNECTION, "SET SQL_MODE = '';");
mysqli_query($MYSQL_CONNECTION, "SET SESSION sql_mode='STRICT_ALL_TABLES';");
