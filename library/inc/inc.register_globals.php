<?php
/**
 * Implementing register_globals = Off
 * It is an optional security feature only and can be skipped
 */

/**
 * Harden the security first
 */
ini_set('register_globals', 'Off');
ini_set('setting session.bug_compat_42', 'Off');
ini_set('session.bug_compat_warn', 'Off');

/**
 * Collect the keys from all possible global variables
 */
$keys = array(
	'env' => array_keys($_ENV),
	'get' => array_keys($_GET),
	'post' => array_keys($_POST),
	'session' => array_keys($_SESSION),
	'request' => array_keys($_REQUEST),
	'cookie' => array_keys($_COOKIE),
	'files' => array_keys($_FILES),
);

/**
 * And unset them all if their variables were found
 * There should be no any creation of php internal variable via such global variables
 */
foreach($keys as $k => $key)
{
	foreach($key as $v => $variable)
	{
		if(isset($$variable))
		{
			unset($$variable);
		}
	}
}

/**
 * Finally unset the variables used in this processing
 */
unset($k);
unset($v);
unset($key);
unset($keys);
unset($variable);
