<?php
#namespace plugins;

/**
 * Converts a timestamp into directory locations by YYYY/MM/DD/HHMMSSXXXX
 */
function smarty_modifier_locate($code = 'YYYYMMDDHHIISSXXXX')
{
	if(preg_match('/^[\d]{18}$/is', $code))
	{
		$data = array();
		$code = preg_replace('/^([\d]{4})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{4})$/is', '$1/$2/$3/$4$5$6$7', $code);
	}
	else
	{
		$code = strtolower(preg_replace('/[^a-z0-9]/is', "", $code));
	}

	return $code;
}
