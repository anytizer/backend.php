<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Details of an entry in [ __ENTITY__ ]
 */

$__ENTITY__ = new \subdomain\__ENTITY__();
$__PK_NAME__ = $variable->get('id', 'integer', 0); # Entity ID
$code = $variable->get('code', 'string', ""); # Protection Code

if(!$__PK_NAME__ || !$code)
{
	# Page was loaded without the ID parameter
	\common\stopper::url('__ENTITY__-direct-access-error.php?context=identity');
}
else
{
	# Check for valid requests
	# if(!$__ENTITY__->is_valid($__PK_NAME__, $code)) \common\stopper::message('Invalid request.', false);

	# Try to load the details
	if($__ENTITY___details = $__ENTITY__->details($__PK_NAME__, $code))
	{
		# We aim to reach here only.
		$smarty->assignByRef('__ENTITY__', $__ENTITY___details);

		# To customize the content titles etc. for SEO purposes if necessary.
		# $page_details['content_title'] = "{$__ENTITY___details['__SINGULAR___name']}";
		# $page_details['page_title'] = "{$__ENTITY___details['__SINGULAR___name']}";
	}
	else
	{
		# Record not found
		\common\stopper::url('__ENTITY__-direct-access-error.php?context=data');
	}
}
