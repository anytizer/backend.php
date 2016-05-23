<?php


# Created on: 2011-02-10 00:12:27 318

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', '');

$ids = $variable->post('licenses', 'array', array());
#print_r($_POST); print_r($ids); die();

$licenses = new \subdomain\licenses();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$licenses->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('licenses-list.php');
