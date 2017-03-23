<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Delete an entity in [ __ENTITY__ ]
 * Our policy is to reset the is_active flag to N (no) to mean a deletion.
 * A record is NOT deleted physically.
 */

# If you do not allow the delete feature, just enable the below line.
# \common\stopper::url('__ENTITY__-list.php');

$__ENTITY__ = new \subdomain\__ENTITY__();
$__PK_NAME__ = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', "");

# Assumes, ID always, in the GET parameter
if($__PK_NAME__ && $code)
{
	if($__ENTITY__->delete('inactivate', $__PK_NAME__, $code))
	{
		$messenger = new \common\messenger('warning', 'The record has been deleted.');

		# \common\stopper::url('__ENTITY__-delete-successful.php');
		# \common\headers::back('__ENTITY__-list.php');
		\common\stopper::url('__ENTITY__-list.php');
	}
	else
	{
		$messenger = new \common\messenger('error', 'The record has NOT been deleted.');

		\common\stopper::url('__ENTITY__-delete-error.php?context=permissions');
	}
}
else
{
	\common\stopper::url('__ENTITY__-direct-access-error.php?context=delete');
}
