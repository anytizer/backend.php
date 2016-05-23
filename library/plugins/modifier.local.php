<?php
#namespace plugins;

/**
 * Determines if the application is running on local system
 */
function smarty_modifier_local($time = 0)
{
	$headers = new \common\headers();

	return $headers->is_local();
}
