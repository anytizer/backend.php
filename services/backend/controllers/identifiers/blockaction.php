<?php


# Created on: 2011-03-18 13:20:47 198

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', "");

$ids = $variable->post('identifiers', 'array', array());
#print_r($_POST); print_r($ids); die();

$identifiers = new \subdomain\identifiers();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$identifiers->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('identifiers-list.php');
