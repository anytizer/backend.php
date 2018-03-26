<?php




/**
 * Lists entities in subdomains
 */

# When a user will cancel add/edit forms, we will try to come back here
\common\url::remember();

# Name of the searched subdoman name
#$subdomain_name = $variable->post('subdomain_name', 'string', "");
#$subdomain_name = $variable->remember_string('subdomain_name', $subdomain_name);
#$subdomain_name = $variable->remember_string('subdomain_name', $variable->post('subdomain_name', 'string', ""));
$subdomain_name = $variable->remember_string('subdomain_name', "");

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
    "e.is_active='Y'", # Do not remove this
    "e.is_hidden='N'", # Manually hidden domains are not useful to manage
));

# Compulsory conditions
$condition->add(
    'AND', array(
        'e.is_active' => 'Y', # Partial %contents%

        # When this is used, reset the pagination indices
        'e.subdomain_name' => $subdomain_name, # Searched sub-domain name
    )
);

# List out the entries
$entries = $subdomains->list_entries(
    $condition,
    $from_index = $pagination->beginning_entry(),
    $pagination->per_page()
);

# Variations
# sn: sub-domain Name
# sc: sub-domain Comments
$sort_name = $variable->find('sort', 'subdomain_name');

# List out the entries
$entries = $subdomains->list_entries(
    $condition,
    $from_index = ($subdomain_name) ? 0 : $pagination->beginning_entry(),
    $pagination->per_page(),
    $sort_name
);

# Pagination helper
$pagination->set_total($subdomains->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('subdomainss', $entries);
