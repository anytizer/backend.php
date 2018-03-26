<?php




/**
 * Lists entities in history
 */

# When a user will cancel add/edit forms, we will try to come back here
\common\url::remember();

# Begin the paginator along with: history
# Parameter: GET[], and per page
$pagination = new \common\pagination('pg', __PER_PAGE__);

$history = new \subdomain\history();

# Be sure NOT to load too many entities. Save the database
# Please modify this code, particularly for:
#	Page Limits
#	Selection Conditions
$search = $variable->post('search-query', 'string', "");
$search_query = $variable->remember_string('search-query');
$smarty->assign('search_query', $search_query);

$condition = new \others\condition();

# Listed records that are bound to the current sub-domain only
$subdomain_id = $variable->get('id', 'integer', 0);
if (!$subdomain_id) {
    $subdomain_id = $framework->subdomain_id();
}

# Compulsory conditions
$condition->add('AND', array(
    # Avoid this line to list the development history of all subdomains
    'e.subdomain_id' => $subdomain_id, # Bind the records

    'e.is_active' => 'Y', # Do not remove this
));

# List out the entries
$entries = $history->list_entries(
    $condition,
    $from_index = $pagination->beginning_entry(),
    $pagination->per_page()
);

# Pagination helper
$pagination->set_total($history->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('historys', $entries);
