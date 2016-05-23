<?php
#namespace plugins;

/**
 * Converts a date into readable day name using Database Query
 */
function smarty_modifier_day($date = '0000-00-00')
{
	if(!preg_match('/^([\d]{4})-([\d]{2})-([\d]{2})$/is', $date))
	{
		return 'N/A';
	}
	if($date == '0000-00-00')
	{
		return 'N/A';
	}

	$day_sql = "SELECT DATE_FORMAT('{$date}', '%W') day_name;";
	$db = new \common\mysql();
	$day = $db->row($day_sql);

	return $day['day_name'];
}
