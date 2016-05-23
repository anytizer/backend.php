<?php
#namespace plugins;

/**
 * Converts a date into Age in years
 * The MySQL offical style of calculating the age in years
 * http://dev.mysql.com/doc/refman/5.0/en/date-calculations.html
 *
 * @example {'2012-08-07'|age}
 */
function smarty_modifier_age($date_of_birth = '0000-00-00')
{
	$dates = array();
	if(!preg_match('/^([\d]{4})-([\d]{2}-[\d]{2})$/', $date_of_birth, $dates))
	{
		return null;
	}

	$age = (date('Y') - $dates[1]) - (date('m-d') < $dates[2] ? 1 : 0);

	return $age;
}
