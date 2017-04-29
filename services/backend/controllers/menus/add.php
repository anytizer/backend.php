<?php


# Created on: 2009-11-11 20:01:53 711

/**
 * Add an entity in [ menus ]
 */

/*
# Posted data:
Array
(
    [menus] => Array
        (
            [menu_context] => admin
            [menu_text] => List all menus
            [menu_link] => menus-list.php
        )

    [add-action] => Add menus
    [submit-button] => Add
)
*/
$menus = new \subdomain\menus();

if ($variable->post('add-action', 'string', "")) {
    $data = $variable->post('menus', 'array', array());
    $data['is_active'] = 'Y';

    if ($menus_id = $menus->add($data)) {
        \common\stopper::url('menus-add-successful.php');
    } else {
        \common\stopper::url('menus-add-error.php');
    }
} else {
    # Must allow a chance to load the ADD form.
    #\common\stopper::url('menus-direct-access-error.php');
}

$contexts = $menus->used_contexts();
$smarty->assign('contexts', $contexts);
