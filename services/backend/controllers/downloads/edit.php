<?php


# Created on: 2010-12-14 00:48:38 194

/**
 * Edit an entity in [ downloads ]
 */

$downloads = new \subdomain\downloads();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', "") && ($distribution_id = $variable->post('distribution_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', "");
	$data = $variable->post('downloads', 'array', array());

	# Mark when this data was modified last time.
	$data['modified_on'] = 'CURRENT_TIMESTAMP()';

	if($success = $downloads->edit(
		$data, # Posted data
		array(
			'distribution_id' => $distribution_id,
		),
		$code, # Security code related to this entry
		$distribution_id
	)
	)
	{
		\common\stopper::url(\common\url::last_page('downloads-list.php'));
		#\common\stopper::url('downloads-edit-successful.php');
		#\common\stopper::url('downloads-list.php');
	}
	else
	{
		\common\stopper::url('downloads-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($distribution_id = $variable->get('id', 'integer', 0))
	{
		$details = $downloads->details($distribution_id);
		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('downloads-edit-error.php');
		}
		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $downloads->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('downloads', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('downloads-direct-access-error.php');
	}
}
