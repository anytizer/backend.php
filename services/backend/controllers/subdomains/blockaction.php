<?php


# Created on: 2011-02-10 00:27:11 536

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', '');

$ids = $variable->post('subdomains', 'array', array());
#print_r($_POST); print_r($ids); die();

$subdomains = new \subdomain\subdomains();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$subdomains->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('subdomains-list.php');
