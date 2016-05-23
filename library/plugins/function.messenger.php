<?php
#namespace plugins;

/**
 * Show dynamic messages.
 * Just believe that the CSS is done already to decorate the messages.
 * Usage in templates
 *
 * @example {messenger}, {messenger code='201104062323305441'}
 * Usage in PHP Coding
 * @example $messenger = new \common\messenger('YYYYMMDDHHIISSXXXX');
 * @example $messenger = new \common\messenger('level', 'message');
 */
function smarty_function_messenger($params = array(), &$smarty)
{
	$envelope = '';

	if(isset($params['code']))
	{
		/**
		 * This block will supercede the default messanger message.
		 * Further, this is a persistent message.
		 * Do not use where the message should vanish right after the display.
		 */
		$code = \common\tools::sanitize($params['code']);
		$db = new \backend\mysql();
		if($messages = $db->row("SELECT message_status, message_body FROM query_messages WHERE message_code='{$code}';"))
		{
			# Because this is the same replacement.
			unset($_SESSION['messenger']);

			$db->query("UPDATE query_messages SET display_counter=display_counter+1 WHERE message_code='{$code}';");
			$envelope = "<div id=\"messenger\" class=\"{$messages['message_status']}\">{$messages['message_body']}</div>";
		}
		else
		{
			# Nessage not found.
			# $envelope = '';
		}
	}
	else
	{
		$messenger = new \common\messenger('', '');

		$level = $messenger->level();
		$message = $messenger->message();

		$messenger->told();

		if($level && $message)
		{
			$envelope = "<div id=\"messenger\" class=\"{$level}\">{$message}</div>";
		}
	}

	return $envelope;
}
