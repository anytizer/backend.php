<?php


# Created on: 2010-11-15 13:36:42 243

/**
 * Edit an entity in [ cdn ]
 */

$cdn = new \subdomain\cdn();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', '') && ($cdn_id = $variable->post('cdn_id', 'integer', 0)))
{
	# Editing....
	$code = $variable->post('protection_code', 'string', '');
	$data = $variable->post('cdn', 'array', array());
	# $data['modified_on'] = 'CURRENT_TIMESTAMP()'; # Additional support, if any

	if($success = $cdn->edit(
		$data, # Posted data
		array(
			'cdn_id' => $cdn_id,
		),
		$code, # Security code related to this entry
		$cdn_id
	)
	)
	{
		\common\stopper::url(\common\url::last_page('cdn-list.php'));
		#\common\stopper::url('cdn-edit-successful.php');
		#\common\stopper::url('cdn-list.php');
	}
	else
	{
		\common\stopper::url('cdn-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	if($cdn_id = $variable->get('id', 'integer', 0))
	{
		$details = $cdn->details($cdn_id);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('cdn', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('cdn-direct-access-error.php');
	}
}
