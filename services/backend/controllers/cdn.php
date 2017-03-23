<?php


# Created on: 2010-11-15 13:36:42 243

/**
 * Lists entities in cdn
 */

# When a user will cancel add/edit forms, we will try to come back here
\common\url::remember();

# Begin the paginator along with: cdn
# Parameter: GET[], and per page
$pagination = new \common\pagination('pg', __PER_PAGE__);

$cdn = new \subdomain\cdn();

# Be sure NOT to load too many entities. Save the database
# Please modify this code, particularly for:
#	Page Limits
#	Selection Conditions
$search = $variable->post('search-query', 'string', "");
$search_query = $variable->remember_string('search-query');
$smarty->assign('search_query', $search_query);

$condition = new \others\condition();

# Compulsory conditions
$condition->add('AND', array(
	'e.is_active' => 'Y', # Do not remove this
));

# List out the entries
$entries = $cdn->list_entries(
	$condition,
	$from_index = $pagination->beginning_entry(),
	$pagination->per_page()
);

# Pagination helper
$pagination->set_total($cdn->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('cdns', $entries);
