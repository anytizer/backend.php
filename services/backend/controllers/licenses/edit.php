<?php


# Created on: 2011-02-10 00:12:27 318

/**
 * Edit an entity in [ licenses ]
 */

$licenses = new \subdomain\licenses();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', "") && ($license_id = $variable->post('license_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', "");
	$data = $variable->post('licenses', 'array', array());

	# Mark when this data was modified last time.
	$data['modified_on'] = 'CURRENT_TIMESTAMP()';

	if($success = $licenses->edit(
		$data, # Posted data
		array(
			'license_id' => $license_id,
		),
		$code, # Security code related to this entry
		$license_id
	)
	)
	{
		# Something about the image uploaders as a patch
		# $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/licenses', 'images/licenses', $record_id=$license_id);

		$messenger = new \common\messenger('success', 'The record has been modified.');

		\common\stopper::url(\common\url::last_page('licenses-list.php'));
		#\common\stopper::url('licenses-edit-successful.php');
		#\common\stopper::url('licenses-list.php');
	}
	else
	{
		\common\stopper::url('licenses-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($license_id = $variable->get('id', 'integer', 0))
	{
		$details = $licenses->details($license_id);
		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('licenses-edit-error.php');
		}
		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $licenses->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('licenses', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('licenses-direct-access-error.php');
	}
}
