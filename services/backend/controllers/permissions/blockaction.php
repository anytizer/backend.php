<?php


# Created on: 2011-03-29 23:48:23 316

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', '');

$ids = $variable->post('permissions', 'array', array());
#print_r($_POST); print_r($ids); die();

$permissions = new \subdomain\permissions();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$permissions->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('permissions-list.php');
