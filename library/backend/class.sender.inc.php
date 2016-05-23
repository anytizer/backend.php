<?php
namespace backend;

require_once(__THIRD_PARTIES__ . '/phpmailer/PHPMailerAutoload.php');

/**
 * Sends an email using a known SMTP account
 *
 * Once in a lifetime of a page, include the phpmailer class.
 * It is not listed in auto loaded classes.
 * Due to SPL, it will NOT check for that!
 * So, just force it to require once.
 * Do NOT test for the PHPMailer class as it will result errors
 */
class sender
	extends \PHPMailer
{
	private $sender_loaded = false;

	public function __construct()
	{
		/**
		 * Invoke the parent's constructor without having to throw \Exceptions.
		 * @todo Fix this class file
		 */
		parent::__construct(false);
	}
	
	/**
	 * @todo After fixing this class, verify setup is always called
	 */
	public function setup($config_name = 'TEST-LOCALHOST')
	{
		$smtp_configurations_sql = "
SELECT
	`smtp_host`, `smtp_port`, do_authenticate,
	smtp_username, smtp_password,
	from_name, from_email,
	replyto_name, replyto_email
FROM query_emails_smtp
WHERE
	smtp_identifier='{$config_name}'
;";
		#echo $smtp_configurations_sql;
		$db = new \common\mysql();
		$configs = $db->row($smtp_configurations_sql);

		if($configs)
		{
			$this->sender_loaded = true;

			$this->SMTPSecure = true;
			$this->SMTPDebug = 2;
			$this->IsSMTP();
			$this->SMTPAuth = ($configs['do_authenticate'] == 'Y');
			$this->Port = $configs['smtp_port'];
			$this->Host = $configs['smtp_host'];
			$this->Username = $configs['smtp_username'];
			$this->Password = $configs['smtp_password'];
			$this->From = $configs['from_email'];
			$this->FromName = $configs['from_name'];

			# Ask for delivery request / read request
			# Header: Disposition-Notification-To
			$this->ConfirmReadingTo = $configs['from_email'];

			# Use it later only - But reply to the same user whose SMTP account was used.
			# This is to control fraudulent usage of this application.
			$this->AddReplyTo($configs['replyto_email'], $configs['replyto_name']);
			$this->AddBCC($configs['replyto_email'], $configs['replyto_name']);
		}
		else
		{
			\common\stopper::debug('SMTP details NOT loaded for: ' . $config_name, true);
		}

		$this->CharSet = 'utf-8'; # Assume, everything as Unicode, and is important!
	}


	/**
	 * Overwrite the default configurations
	 * Resets the details of a sender
	 */
	public function reset_sender(\others\datatype_recipient $recipient)
	{
		$this->From = $recipient->email;
		$this->FromName = $recipient->name;

		# Optionally, reset the reply-to too, which means, the originating sender is a receiver as well.
		#$this->ReplyTo = array();
		#$this->AddReplyTo($recipient->email, $recipient->name);
	}

	/**
	 * Overwrite the default configurations
	 * Resets the details of a recipient, reply to
	 */
	public function reset_reply_to(\others\datatype_recipient $recipient)
	{
		$this->ReplyTo = array();
		if($recipient->is_valid())
		{
			$this->AddReplyTo($recipient->email, $recipient->name);
		}
	}

	/**
	 * Add an recipient
	 */
	public function add_recipient(\others\datatype_recipient $recipient)
	{
		if($recipient->is_valid())
		{
			# AddAddress | AddCC | AddBCC | AddReplyTo | AddAnAddress
			$this->AddAddress($recipient->email, $recipient->name);
		}
	}

	/**
	 * Send an email
	 */
	public function deliver(\others\datatype_email $email_data, $config_name = 'TEST-LOCALHOST')
	{
		$this->Subject = $email_data->subject;
		$this->Body = $email_data->html;
		$this->AltBody = $email_data->text;

		# Compose and send the email to the recipient, now.
		$delivery = ($email_data->is_valid() && $this->sender_loaded === true) ? parent::Send() : false;
		return $delivery;
	}

	/**
	 * A modified clone of PHPMailer::MsgHTML() function
	 * Embeds images within an email.
	 */
	public function embed($message, $basedir = '')
	{
		preg_match_all("/(src|background)=\"(.*)\"/Ui", $message, $images);
		if(!isset($images[2]))
		{
			return $message;
		}
		foreach($images[2] as $i => $url)
		{
			// do not change urls for absolute images (thanks to corvuscorax)
			if(!preg_match('#^[A-z]+://#', $url))
			{
				$filename = basename($url);
				$directory = dirname($url);
				($directory == '.') ? $directory = '' : '';
				$cid = 'cid:' . md5($filename);
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$mimeType = self::_mime_types($ext);
				if(strlen($basedir) > 1 && substr($basedir, -1) != '/')
				{
					$basedir .= '/';
				}
				if(strlen($directory) > 1 && substr($directory, -1) != '/')
				{
					$directory .= '/';
				}
				if($this->AddEmbeddedImage($basedir . $directory . $filename, md5($filename), $filename, 'base64', $mimeType))
				{
					$message = preg_replace(
						"/" . $images[1][$i] . "=\"" . preg_quote($url, '/') . "\"/Ui",
						$images[1][$i] . "=\"" . $cid . "\"",
						$message
					);
				} # if
			} # if
		} # foreach
		return $message;
	}

	/**
	 * Reads a plain text file and returns the HTML with BR tags.
	 * Helpful to create footer signatures.
	 *
	 * @todo Support MarkDown (.md) as well | Parsedown is also good
	 */
	public function file2html($filename = '')
	{
		$file_contents = '';
		if(is_file($filename))
		{
			$file_contents = (nl2br(file_get_contents($filename)));
		}

		return $file_contents;
	}
}
