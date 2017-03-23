<?php
namespace interfaces;

/**
 * Halts a page on certain error
 * @todo Interface not found
 *
 * @package Interfaces
 */
class error
{
	private $errors;

	public function __construct()
	{
	}
	
	/**
	 * @todo Fix this class
	 */
	public function process($ini_file = "")
	{
		if(file_exists($ini_file))
		{
			$this->errors = parse_ini_file($ini_file, true);
			#\common\stopper::debug($this->errors, false);
		}
		else
		{
			# Default: login.ini
			# Fill this according to the project's need.
			$this->errors = array(
				'login' => array(
					'existence' => 'User account does not exist.',
					'unmatched' => 'Password does not match.',
					'expired' => 'User account is expired.',
					'disabled' => 'User is disabled purposefully by the admin.',
					'locked' => 'User is locked (over accessed).',
				),
			);
		}
	}

	public function message($reason = "")
	{
		$message = "";

		$reason = preg_replace('/[^a-z0-9\>\:]+/is', "", strtolower($reason));
		$why = preg_split('/\>|\:/is', $reason);
		if(count($why) < 2)
		{
			$message = 'Insufficient Section &gt; Error (eg. Login &gt; Invalid): ' . $reason;
		}
		else
		{
			#\common\stopper::debug($why, false);
			# eg: 0: login, 1: expired
			$section = $why[0];
			$explanation = $why[1];
			if(isset($this->errors[$section][$explanation]))
			{
				$message = $this->errors[$section][$explanation];
			}
			else
			{
				$message = "Error occurred, but I could not find the error message there for: {$section} &gt; {$explanation}. Warning: It is CASE SENSITIVE.";
			}
		}

		return $message;
	}

	public function stop($reason = "")
	{
		die($this->message($reason));
	}
}
