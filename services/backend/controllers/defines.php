<?php


# Created on: 2010-06-16 21:19:04 969

/**
 * Lists entities in defines
 */

# Begin the paginator along with: defines
$pagination = new \common\pagination('pg', __PER_PAGE__); # Parameter: GET[], and per page

$defines = new \subdomain\defines();

# Be sure NOT to load too many entities. Save the database
# Please modify this code, particularly for:
#	Page Limits
#	Selection Conditions
$search = $variable->post('search-query', 'string', '');
$search_query = $variable->remember_string('search-query');
$smarty->assign('search_query', $search_query);

$condition = new \others\condition();

# Compulsory conditions
$condition->add('AND', array(
	'e.is_active' => 'Y', # Do not remove this
));

# List out the entries
$entries = $defines->list_entries(
	$condition,
	$from_index = $pagination->beginning_entry(),
	$pagination->per_page()
);

# Pagination helper
$pagination->set_total($defines->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('definess', $entries);
