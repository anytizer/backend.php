<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Lists entities in smtp
 */

# Begin the paginator along with: smtp
$pagination = new \common\pagination('pg', __PER_PAGE__); # Parameter: GET[], and per page

$smtp = new \subdomain\smtp();

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
$entries = $smtp->list_entries(
    $condition,
    $from_index = $pagination->beginning_entry(),
    $pagination->per_page()
);

# Pagination helper
$pagination->set_total($smtp->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('smtps', $entries);
