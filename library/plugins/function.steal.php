<?php
#namespace plugins;

/**
 * Steals a value of another template variable
 *
 * @link http://www.smarty.net/forums/viewtopic.php?p=60628#60628
 */
function smarty_function_steal($params = array(), &$smarty)
{
	$stolen_value = null;
	if(!empty($params['tag']))
	{
		if(isset($smarty->_tpl_vars[$params['tag']]))
		{
			$stolen_value = $smarty->_tpl_vars[$params['tag']];
		}
	}

	return $stolen_value;
}
