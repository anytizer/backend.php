<?php


# Created on: 2011-02-14 12:48:48 850

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', "");

$ids = $variable->post('domains', 'array', array());
#print_r($_POST); print_r($ids); die();

$domains = new \subdomain\domains();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$domains->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('domains-list.php');
