<?php




/**
 * Lists entities in subdomains
 */

# When a user will cancel add/edit forms, we will try to come back here
\common\url::remember();

# Begin the paginator along with: subdomains
# Parameter: GET[], and per page
$pagination = new \common\pagination('pg', __PER_PAGE__);

$subdomains = new \subdomain\subdomains();

# Be sure NOT to load too many entities. Save the database
# Please modify this code, particularly for:
#	Page Limits
#	Selection Conditions
$search = $variable->post('search-query', 'string', "");
$search_query = $variable->remember_string('search-query');
$smarty->assign('search_query', $search_query);

$condition = new \others\condition();

$condition->add('FULL', array(
    #"e.subdomain_id={$subdomain_id}", # Bind the records
    "e.is_active='Y'", # Do not remove this
));

# Compulsory conditions
$condition->add('AND', array( #'e.search_field' => 'Y', # Partial %contents%
));

# List out the entries
$entries = $subdomains->list_entries(
    $condition,
    $from_index = $pagination->beginning_entry(),
    $pagination->per_page()
);

# Pagination helper
$pagination->set_total($subdomains->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('subdomainss', $entries);