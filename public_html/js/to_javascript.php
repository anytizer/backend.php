<?php


# Reads and sends the contents of externally written javascript.

require_once('../inc.bootstrap.php');
require_once('../library/inc/inc.config.php');
\common\headers::javascript();

/*
print_r($_GET);
Array
(
    [js] => ee3aa49f33b400a5a5a2bc996022717f.js
)*/

# To protect stealing of this script, do:
#if(preg_match('/detail\.php\?id\=[\d]+/is', $_SERVER['HTTP_REFERER']))
if(empty($_SERVER['HTTP_REFERER']))
{
	echo '//Sorry';
}
else
{
	if($js_file = $variable->get('js', 'string', ""))
	{
		$js_file = $js_file . '.js';

		/**
		 * @todo Fix as contructions are without parameters
		 */
		$tj = new to_javascript();
		$tj->send_javascript(__TEMP_PATH__ . '/to_javascript-'.$js_file);
	}
	else
	{
		echo '//sorry!';
	}
}