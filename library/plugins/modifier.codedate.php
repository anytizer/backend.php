<?php
#namespace plugins;

/**
 * Converts our codes into the date format
 * @example YYYYMMDDHHIISSXXXX => YYYY-MM-DD HH:II:SS
 */
function smarty_modifier_codedate($code = 'YYYYMMDDHHIISSXXXX')
{
	$code = preg_replace('/[^\d]+/', "", $code);
	$date = preg_replace('/^([\d]{4})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{4})$/', '$1-$2-$3 $4:$5:$6', $code);
	
	/**
	 * If today, show the time part only
	 */
	$date = str_replace(date('Y-m-d'), "", $date);
	$date = trim($date);

	return $date;
}
