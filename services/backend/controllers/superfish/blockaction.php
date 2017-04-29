<?php


# Created on: 2011-02-02 01:46:49 751

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', "");
$ids = $variable->post('superfish', 'array', array());

$superfish = new \subdomain\superfish();

switch ($action) {
    case 'delete':
    case 'disable':
    case 'enable':
    case 'prune':
        $superfish->blockaction($action, $ids);
        break;
    case 'nothing':
    default:
        break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('superfish-list.php');
