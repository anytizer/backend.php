<?php


# Created on: 2011-03-29 23:48:23 316

/**
 * Edit an entity in [ permissions ]
 */

$permissions = new \subdomain\permissions();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && ($crud_id = $variable->post('crud_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', '');
	$data = $variable->post('permissions', 'array', array());

	# Mark when this data was modified last time.
	$data['modified_on'] = 'CURRENT_TIMESTAMP()';

	if($success = $permissions->edit(
		$data, # Posted data
		array(
			'crud_id' => $crud_id,
		),
		$code, # Security code related to this entry
		$crud_id
	)
	)
	{
		# Something about the image uploaders as a patch
		# $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/permissions', 'images/permissions', $record_id=$crud_id);

		$messenger = new \common\messenger('success', 'The record has been modified.');

		\common\stopper::url(\common\url::last_page('permissions-list.php'));
		#\common\stopper::url('permissions-edit-successful.php');
		#\common\stopper::url('permissions-list.php');
	}
	else
	{
		\common\stopper::url('permissions-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($crud_id = $variable->get('id', 'integer', 0))
	{
		$details = $permissions->details($crud_id);
		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('permissions-edit-error.php');
		}
		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $permissions->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('permissions', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('permissions-direct-access-error.php');
	}
}
