<?php


# Created on: 2011-04-06 14:42:31 485

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', '');

$ids = $variable->post('messages', 'array', array());
#print_r($_POST); print_r($ids); die();

$messages = new \subdomain\messages();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$messages->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('messages-list.php');
