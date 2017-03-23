<?php
#namespace plugins;

/**
 * Reads the database and drops down a menu using superfish
 */
function smarty_modifier_superfish($context = "", $force_compile = false)
{
	$dd = new \backend\dropdown($context);

	# Force a menu bound to a subdomain only.
	$framework = new \backend\framework();
	$dd->subdomain_id($framework->subdomain_id());

	# Now onwards, the menus once produced are cached by default.
	# You can change the template's call to force compiling.
	# On default, it is served as a cached file, for performances.
	$dropdown = $dd->build($force_compile === true);

	return $dropdown;
}
