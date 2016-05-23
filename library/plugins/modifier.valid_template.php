<?php
#namespace plugins;

/**
 * Checks the presense of a template.
 * Usage example:
 * {if $page.include_file|valid_template}{include file=$page.include_file}{/if}
 */
function smarty_modifier_valid_template($template_name = '')
{
	$exists = false;
	if($template_name)
	{
		# $smarty is a general assumtion of Smarty variable.
		global $smarty;
		if(($exists = $smarty->templateExists($template_name)) == false)
		{
			# Template not found
			# Take some action here.
			# But most likely, do nothing.
			# echo 'Template NOT found';
		}
	}

	return $exists;
}
