<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Perform a block action in entities. Input is via POST only
 */

$action = $variable->post('action', 'string', '');
$ids = $variable->post('__ENTITY__', 'array', array());
#print_r($_POST); print_r($ids); die();

# Safety preceutions, make all the IDs a list of numbers only.
$ao = new \common\array_operation();
$ids = $ao->operate('numeric', $ids);
$ids = array_filter($ids);
if(!count($ids))
{
	$ids = array(0);
}

$__ENTITY__ = new \subdomain\__ENTITY__();

switch($action)
{
	case 'delete':
	case 'disable':
	case 'enable':
	case 'prune':
		$__ENTITY__->blockaction($action, $ids);
		break;
	case 'nothing':
	default:
		break;
}

/**
 * Go back to the page that referred here.
 */
\common\headers::back('__ENTITY__-list.php');
