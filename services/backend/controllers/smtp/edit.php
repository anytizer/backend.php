<?php


# Created on: 2010-10-06 12:53:18 781

/**
 * Edit an entity in [ smtp ]
 */

$smtp = new \subdomain\smtp();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && ($smtp_id = $variable->post('smtp_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', '');
	$data = $variable->post('smtp', 'array', array());
	# $data['modified_on']  = 'CURRENT_TIMESTAMP()'; # 'UNIX_TIMESTAMP(CURRENT_TIMESTAMP())'; # Additional support, if any

	if($success = $smtp->edit(
		$data, # Posted data
		array(
			'smtp_id' => $smtp_id,
		),
		$code, # Security code related to this entry
		$smtp_id
	)
	)
	{
		#\common\stopper::url('smtp-edit-successful.php');
		\common\stopper::url('smtp-list.php');
	}
	else
	{
		\common\stopper::url('smtp-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($smtp_id = $variable->get('id', 'integer', 0))
	{
		$details = $smtp->details($smtp_id);

		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('smtp-edit-error.php');
		}
		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $smtp->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('smtp', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('smtp-direct-access-error.php');
	}
}
