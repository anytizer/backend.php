<?php




/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', "");

$ids = $variable->post('cms', 'array', array());
#print_r($_POST); print_r($ids); die();

$cms = new \subdomain\cms();

switch ($action) {
    case 'delete':
    case 'disable':
    case 'enable':
    case 'prune':
        $cms->blockaction($action, $ids);
        break;
    case 'nothing':
    default:
        break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('cms-list.php');
