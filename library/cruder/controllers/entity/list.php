<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Lists entities in __ENTITY__
 */

# When a user will cancel add/edit forms, we will try to come back here
\common\url::remember();

# Begin the paginator along with: __ENTITY__
# Parameter: GET[], and per page
$pagination = new \common\pagination('pg', __PER_PAGE__);

$__ENTITY__ = new \subdomain\__ENTITY__();

# Be sure NOT to load too many entities. Save the database
# Please modify this code, particularly for:
#	Page Limits
#	Selection Conditions
$search___ENTITY__ = $variable->remember_string('search___ENTITY__');
$smarty->assign('search___ENTITY__', $search___ENTITY__);

# Clicking on the refresh() button/link will clear the memory
#if($reset_random = $variable->get('random', 'string', "")) { $variable->forget('somefk_id'); }
#$somefk_id = $variable->remember_as('id', 'somefk_id');

$condition = new \others\condition();

$condition->add('FULL', array(
    "e.subdomain_id={$subdomain_id}", # Bind the records with this sub-domain only
    "e.is_active='Y'", # Do not remove this
    #"e.is_approved='Y'", # Optionally use this flag

    # Filter list of records by some FK/ID
    # $somefk_id?"e.somefk_id={$somefk_id}":"",

    # In search.php
    # $search___ENTITY__?"(e.field_name LIKE '%{$search___ENTITY__}%' OR e.field_name LIKE '%{$search___ENTITY__}%')":"",
));

# Compulsory conditions
$condition->add('AND', array(#'e.search_field' => 'Y', # Partial %contents%
));

# List out the entries
$entries = $__ENTITY__->list_entries(
    $condition,
    $from_index = $pagination->beginning_entry(),
    $pagination->per_page()
);

# Pagination helper
$pagination->set_total($__ENTITY__->total_entries());
$smarty->assignByRef('pagination', $pagination);

# Assign to Smarty: Lists
$smarty->assignByRef('__ENTITY__s', $entries);
