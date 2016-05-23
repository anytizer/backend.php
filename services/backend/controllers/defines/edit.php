<?php


# Created on: 2010-06-16 21:19:04 969

/**
 * Edit an entity in [ defines ]
 */

$defines = new \subdomain\defines();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && ($define_id = $variable->post('define_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', '');
	$data = $variable->post('defines', 'array', array());
	$data['modified_on'] = 'CURRENT_TIMESTAMP()'; # Additional support, if any

	if($success = $defines->edit(
		$data, # Posted data
		array(
			'define_id' => $define_id,
		),
		$code, # Security code related to this entry
		$define_id
	)
	)
	{
		#\common\stopper::url('defines-edit-successful.php');
		\common\stopper::url('defines-list.php');
	}
	else
	{
		\common\stopper::url('defines-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($define_id = $variable->get('id', 'integer', 0))
	{
		$details = $defines->details($define_id);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('defines', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('defines-direct-access-error.php');
	}
}
