<?php
#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Reverts the flag of a single known field (pre-defined in the class file)
 *
 * @todo Check for HTTP Referrer validity
 * @todo Accept GET/POST requests
 * @todo Make this page AJAX friendly
 */

$__ENTITY__ = new \subdomain\__ENTITY__();
$__PK_NAME__ = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', "");
$flag = $variable->get('flag', 'string', "");

/**
 * Process request as Ajax Call
 */
$ajax = $variable->get('ajax', 'string', 'false') == 'true';

# Assumes, ID always, in the GET parameter
if($__PK_NAME__ != 0 && $code != "" && $flag != "")
{
	$data = $__ENTITY__->details($__PK_NAME__, $code);
	if(!$data)
	{
		if($ajax)
		{
			\common\stopper::message('N', false);
		}

		$messenger = new \common\messenger('error', 'Invalid data.');
		\common\stopper::url(\common\url::last_page('__ENTITY__-list.php?context=invaliddata'));
	}
	if(empty($data['code']) || $data['code'] != $code)
	{
		if($ajax)
		{
			\common\stopper::message('N', false);
		}

		$messenger = new \common\messenger('warning', 'Verification code is invalid.');
		\common\stopper::url(\common\url::last_page('__ENTITY__-list.php?context=invalidcode'));
	}

	if($__ENTITY__->flag_field($__PK_NAME__, $code, $flag))
	{
		if($ajax)
		{
			\common\stopper::message('Y', false);
		}

		$messenger = new \common\messenger('notice', 'The record has been successfully flagged.');

		# The list from where the flag was applied will appear back with pagination.
		\common\headers::back(\common\url::last_page('__ENTITY__-list.php?flagging=successful'));
	}
	else
	{
		if($ajax)
		{
			\common\stopper::message('N', false);
		}

		$messenger = new \common\messenger('error', 'The record has NOT been flagged yet. Such flag does not exist.');
		\common\stopper::url(\common\url::last_page('__ENTITY__-list.php?context=flagging'));
	}
}
else
{
	if($ajax)
	{
		\common\stopper::message('N', false);
	}

	\common\stopper::url('__ENTITY__-direct-access-error.php?context=flagging');
}
