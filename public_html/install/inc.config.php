<?php
/**
 * Configure database details and other variables.
 * Intensions: to help first time users during their installation.
 */

$stamp = @date('Ymd') . mt_rand(1000, 9999);

$config = array(
	'MYSQLHOSTNAME' => 'localhost', # most probable host name is: localhost
	'MYSQLDATABASE' => 'db' . $stamp,
	'MYSQLUSERNAME' => 'user' . $stamp,
	'MYSQLPASSWORD' => 'pass' . mt_rand(10000, 99999) . mt_rand(10000, 99999),

	'frameworkname' => 'backend',
	'framework_id' => '27', # as stored in the database
);
