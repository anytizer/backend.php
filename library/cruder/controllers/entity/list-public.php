<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Lists entities in __ENTITY__
 */

# Begin the paginator along with: __ENTITY__
# Parameter: GET[], and per page
$pagination = new \common\pagination('pg', __PER_PAGE__);

$__ENTITY__ = new \subdomain\__ENTITY__();

$search___ENTITY__ = $variable->remember_string('search___ENTITY__');
$smarty->assign('search___ENTITY__', $search___ENTITY__);

$condition = new \others\condition();

$condition->add('FULL', array(
    "e.subdomain_id={$subdomain_id}", # Bind the records with this sub-domain only
    "e.is_active='Y'", # Do not remove this
    "e.is_approved='Y'", # Optionally use this flag

    # In search.php
    # $search___ENTITY__?"(e.field_name LIKE '%{$search___ENTITY__}%' OR e.field_name LIKE '%{$search___ENTITY__}%')":"",
));

# Compulsory conditions
$condition->add('AND', array( #'e.search_field' => 'Y', # Partial %contents%
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
