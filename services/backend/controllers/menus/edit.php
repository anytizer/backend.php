<?php


# Created on: 2009-11-11 20:01:53 711

/**
 * Edit an entity in [ menus ]
 */

$menus = new \subdomain\menus();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && $menus_id = $variable->post('menus_id', 'integer', 0))
{
	# Editing....
	$data = $variable->post('menus', 'array', array());
	#\common\stopper::message($data); \common\stopper::message();
	if($menus_id = $menus->edit(
		$data,
		array(
			'menu_id' => $menus_id,
		),
		$code = $variable->post('protection_code', 'string', ''),
		$menus_id
	)
	)
	{
		\common\stopper::url('menus-edit-successful.php');
	}
	else
	{
		\common\stopper::url('menus-edit-error.php');
	}
}

/**
 * Otherwise, load the details of the entity before editing it.
 */
if($menus_id = $variable->get('id', 'integer', 0))
{
	$details = $menus->details($menus_id);

	/**
	 * Build Smarty Variable
	 */
	$smarty->assign('menus', $details);

	$contexts = $menus->used_contexts();
	$smarty->assign('contexts', $contexts);
}
else
{
	# Bad...
	\common\stopper::url('menus-direct-access-error.php');
}
