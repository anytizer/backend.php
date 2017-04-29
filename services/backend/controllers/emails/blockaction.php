<?php


# Created on: 2011-03-23 11:38:46 911

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', "");

$ids = $variable->post('emails', 'array', array());
#print_r($_POST); print_r($ids); die();

$emails = new \subdomain\emails();

switch ($action) {
    case 'delete':
    case 'disable':
    case 'enable':
    case 'prune':
        $emails->blockaction($action, $ids);
        break;
    case 'nothing':
    default:
        break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('emails-list.php');
