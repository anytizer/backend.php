<?php
#namespace plugins;

/**
 * Matches if a parameter can be considered as 'true'.
 *
 * @return boolean Success
 */

function smarty_modifier_matchtrue($value = null)
{
	return $value ? true : false;
}
