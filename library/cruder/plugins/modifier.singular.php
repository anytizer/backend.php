<?php
#namespace plugins;

/**
 * Finds out a Name from its ID for __ENTITY__
 * This is an auto generated |__ENTITY__ modifier - please fix it according to your needs
 * @usage {id|__SINGULAR__}
 * @usage {id|__SINGULAR__|false}
 */
function smarty_modifier___SINGULAR__($__SINGULAR___id = 0, $show_link = true)
{
	$link = "";
	$page = constant('IS_ADMINISTRATOR') ? '__ENTITY__-details.php' : '__SINGULAR__.php';

	$__SINGULAR___id = (int)$__SINGULAR___id;
	if($__SINGULAR___id)
	{
		$__ENTITY__ = new \subdomain\__ENTITY__();
		$__SINGULAR__ = $__ENTITY__->details($__SINGULAR___id);
		if($__SINGULAR__)
		{
			$link = ($show_link === true) ? "<a href='{$page}?id={$__SINGULAR__['__SINGULAR___id']}&amp;code={$__SINGULAR__['code']}'>{$__SINGULAR__['__SINGULAR___name']}</a>" : $__SINGULAR__['__SINGULAR___name'];
		}
		else
		{
			#$link = 'Invalid';
		}
	}

	return $link;
}
