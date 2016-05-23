<?php


# Created on: 2011-02-09 23:25:11 836

/**
 * Edit an entity in [ cms ]
 */

$cms = new \subdomain\cms();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && ($page_id = $variable->post('page_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', '');
	$data = $variable->post('cms', 'array', array());

	# Mark when this data was modified last time.
	$data['modified_on'] = 'CURRENT_TIMESTAMP()';

	if($success = $cms->edit(
		$data, # Posted data
		array(
			'page_id' => $page_id,
		),
		$code, # Security code related to this entry
		$page_id
	)
	)
	{
		# Something about the image uploaders as a patch
		# $cu = new customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/cms', 'images/cms', $record_id=$page_id);

		$messenger = new \common\messenger('success', 'The record has been modified.');

		\common\stopper::url(\common\url::last_page('cms-list.php'));
		#\common\stopper::url('cms-edit-successful.php');
		#\common\stopper::url('cms-list.php');
	}
	else
	{
		\common\stopper::url('cms-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($page_id = $variable->get('id', 'integer', 0))
	{
		$details = $cms->details($page_id);
		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('cms-edit-error.php');
		}
		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $cms->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('cms', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('cms-direct-access-error.php');
	}
}
