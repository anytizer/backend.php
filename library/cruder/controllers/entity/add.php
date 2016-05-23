<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Add an entity in [ __ENTITY__ ]
 */

$__ENTITY__ = new \subdomain\__ENTITY__();

if($variable->post('add-action', 'string', ''))
{
	# Posted Data: Apply security
	$data = $variable->post('__ENTITY__', 'array', array());

	# Immediately activate the record
	$data['is_active'] = 'Y';
	$data['is_approved'] = 'Y';

	# When this record is added for the first time?
	$data['added_on'] = 'CURRENT_TIMESTAMP()';

	# Bind the data edited, to the current subdomain only, if there is a subdomain_id column
	$data['subdomain_id'] = $subdomain_id;

	/*
	# If there are some FILEs to upload, please do now.
	# And assign the name of the file returned, to the same field.
	$uploader = new \backend\uploader(__SUBDOMAIN_BASE__.'/templates/images/__ENTITY__', true);
	$file_field_name = 'file_field';
	$file_field = $uploader->store($file_field_name, '');
	if($file_field)
	{
		$data[$file_field_name] = $file_field;
		# Produce the cropnail for uploaded images, if any. Adjust the dimensions as well.
		$original_image = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/'.$data[$file_field_name];
		$cropnail_image = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/thumbs/'.$data[$file_field_name];
		$cropnail = new \images\cropnail($configurations['DEFAULT_IMAGE_WIDTH'], $configurations['DEFAULT_IMAGE_HEIGHT']);
		$cropnail->resize($original_image, $cropnail_image, 0);
	}*/


	if($__PK_NAME__ = $__ENTITY__->add($data, false))
	{
		# Destroy current successful data for the next form.
		unset($_SESSION['attempt___ENTITY__']);

		# Treat/Patch something on the currently added record.
		# Case: Send a welcome message (and ask to authenticate), if applies, eg. as in Membership.
		# $__ENTITY__->welcome_first($__PK_NAME__);

		$messenger = new \common\messenger('success', 'The record has been added.');

		# Jump to the valid details page
		$data = $__ENTITY__->details($__PK_NAME__, $__ENTITY__->code($__PK_NAME__));
		\common\stopper::url("__ENTITY__-details.php?id={$data['__PK_NAME__']}&code={$data['code']}");

		# \common\stopper::url(\common\url::last_page('__ENTITY__-list.php'));
		# \common\stopper::url('__ENTITY__-add-successful.php');
		# \common\stopper::url('__ENTITY__-list.php');
		# \common\stopper::url("__ENTITY__-edit.php?id={$__PK_NAME__}&code={$code}");
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record was NOT added. Does the table exist? Are the column names intact? Also, please check the <strong>database error</strong> log.');

		$_SESSION['attempt___ENTITY__'] = $data;
		\common\stopper::url('__ENTITY__-add.php');
		#\common\stopper::url('__ENTITY__-add-error.php');
	}
}
else
{
	# Must allow a chance to load the ADD form.
	# \common\stopper::url('__ENTITY__-direct-access-error.php');

	# Purpose of this code block is to make sure that the variable
	# gets all indices with blank data, to feed to ADD form.

	# A dynamic details about this record
	$details = array();

	if(isset($_SESSION['attempt___ENTITY__']))
	{
		$details = $_SESSION['attempt___ENTITY__'];
		unset($_SESSION['attempt___ENTITY__']);
	}

	# Validate it against the parameters in itself, plus those what we need.
	$details = $__ENTITY__->validate('add', $details);
	$smarty->assign('__ENTITY__', $details);
}

$smarty->assign('protection_code', $__ENTITY__->code());
