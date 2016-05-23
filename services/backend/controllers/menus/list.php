<?php


# Created on: 2009-11-11 20:01:53 711

/**
 * Lists entities in menus
 */

$menus = new \subdomain\menus();
$entries = $menus->list_entries(array());

$smarty->assignByRef('menuss', $entries);
