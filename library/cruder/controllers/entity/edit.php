<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Edit an entity in [ __ENTITY__ ]
 */

$__ENTITY__ = new \subdomain\__ENTITY__();

# Handle Editing, when data is supplied
if($variable->post('edit-action', 'string', "") && ($__PK_NAME__ = $variable->post('__PK_NAME__', 'integer', 0)))
{
	# Refer to old records in case we need it
	$code = $variable->post('protection_code', 'string', "");
	$old = $__ENTITY__->details($__PK_NAME__, $code);
	if(!$old)
	{
		$messenger = new \common\messenger('success', 'The record does not exist.');
		\common\stopper::url('__ENTITY__-edit-error.php?context=nodata');
	}

	# Editing....
	$data = $variable->post('__ENTITY__', 'array', array());

	# Mark when this data was modified last time.
	$data['modified_on'] = 'CURRENT_TIMESTAMP()';
	$data['modified_counter'] = 'modified_counter+1';

	# If there are some FILEs to upload, please do now.
	# And assign the name of the file returned, to the same field.
	/**
	 * $uploader = new \backend\uploader(__SUBDOMAIN_BASE__.'/templates/images/__ENTITY__', true);
	 * $file_field_name = 'file_field';
	 * $file_field = $uploader->store($file_field_name, "");
	 * if($file_field)
	 * {
	 * $data[$file_field_name] = $file_field;
	 * if(is_file(__SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/'.$old[$file_field_name]))
	 * {
	 * # Old uploaded file should be probably lost. So, delete it first.
	 * # $data[$file_field_name] = uploader::upload_delete($__PK_NAME__, $old[$file_field_name]);
	 * # Produce the cropnail for uploaded images, if any. Adjust the dimensions as well.
	 * $original_image = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/'.$data[$file_field_name];
	 * $cropnail_image = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/thumbs/'.$data[$file_field_name];
	 * $cropnail = new \images\cropnail($configurations['DEFAULT_IMAGE_WIDTH'], $configurations['DEFAULT_IMAGE_HEIGHT']);
	 * $cropnail->resize($original_image, $cropnail_image, 0);
	 * }
	 * }*/

	if($success = $__ENTITY__->edit(
		$data, # Posted data
		array(
			'__PK_NAME__' => $__PK_NAME__,
		),
		$code, # Security code related to this entry
		$__PK_NAME__
	)
	)
	{
		# Something about the image uploaders as a patch, if applies
		# $cu = new \backend\customized_uploader('uploader', __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__', 'images/__ENTITY__', $record_id=$__PK_NAME__);

		/*# Optionally remove old uploaded file, if any
		if($data[$file_field_name])
		{
			$file_field = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/'.$old[$file_field_name];
			if(is_file($file_field))
			{
				unlink($file_field);
			}
			$file_field = __SUBDOMAIN_BASE__.'/templates/images/__ENTITY__/thumbs/'.$old[$file_field_name];
			if(is_file($file_field))
			{
				unlink($file_field);
			}
		}*/

		$messenger = new \common\messenger('success', 'The record has been modified.');

		\common\stopper::url(\common\url::last_page('__ENTITY__-list.php?context=permissions'));
		#\common\stopper::url('__ENTITY__-edit-successful.php');
		#\common\stopper::url('__ENTITY__-list.php');
	}
	else
	{
		\common\stopper::url('__ENTITY__-edit-error.php');
	}
}
else
{
	/**
	 * Otherwise, load the details of the entity before editing it.
	 */
	$code = $variable->get('code', 'string', ""); # Protection Code
	if($__PK_NAME__ = $variable->get('id', 'integer', 0))
	{
		$details = $__ENTITY__->details($__PK_NAME__, $code);
		if(!$details)
		{
			# Data about this entity was not available
			\common\stopper::url('__ENTITY__-edit-error.php?context=data');
		}

		if($details['code'] != $variable->get('code', 'string', ""))
		{
			$messenger = new \common\messenger('error', 'You are attempting to edit wrong data.');
			\common\stopper::url('__ENTITY__-edit-error.php?context=attemptedwrongdata');
		}

		# Purpose of this code block is to make sure that the variable
		# gets all indices with blank data, to feed to EDIT form.
		$details = $__ENTITY__->validate('edit', $details);

		/**
		 * Build Smarty Variable with FULL details
		 */
		$smarty->assign('__ENTITY__', $details);
	}
	else
	{
		# Really Bad...
		\common\stopper::url('__ENTITY__-direct-access-error.php');
	}
}
