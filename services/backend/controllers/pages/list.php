<?php


# "Cancel" links in Add and Edit pages will come back here.
\common\url::remember();

# Test, if a specific subdomain was queried
$subdomain_id = $variable->remember('subdomain_id', 0);
if(!$subdomain_id)
{
	/**
	 * @todo Deprecate this feature
	 */
	# For blank Subdomain ID, draw one from current subdomain
	$subdomain_id = $pages->subdomain_id_for_current_subdomain();

	# Save subdomain_id right now.
	$variable->write('session', 'subdomain_id', $subdomain_id);
}

$pages_list = $pages->list_pages($subdomain_id);
$smarty->assignByRef('pages', $pages_list);
