<?php
#namespace plugins;

/**
 * Random text generator
 * Can be useful in:
 *    Generating the random texts for form validations, check against spams
 *    Random Password Generation
 *
 * @param array $params
 * @param $smarty
 * @return string
 */
function smarty_function_random($params = array(), &$smarty)
{
	$length = isset($params['length']) ? (int)$params['length'] : 5;
	if($length > 32 || $length < 1)
	{
		$length = 5;
	}

	$salt = strrev(md5(mt_rand(1000, 9999) . microtime() . mt_rand(100, 999)));
	$random = substr($salt, 0, $length);

	return $random;
}
