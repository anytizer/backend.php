<?php
namespace common;

/**
 * Halts browsing this website, before our minimum tolerable waiting time.
 *
 * @package Common
 */
class dos
{
	/**
	 * The constructor itself prevents the DOS Attack.
	 * @todo Fix this class/constructor
	 *
	 * @param int $mininum_waiting
	 */
	public function __construct()
	{
	}
	
	/**
	 * @todo Fix
	 */
	public function halt($mininum_waiting = 5)
	{
		$mininum_waiting = (int)$mininum_waiting;
		$mininum_waiting = ($mininum_waiting) ? $mininum_waiting : 5;

		# search a way to skip self-redirected pages.
		# for example, error messages as quickly as a page has just completed rendering.

		$is_first = false;
		$difference = 0;
		$when = 0;

		if(empty($_SESSION['REQUEST_TIME']))
		{
			# First time
			$is_first = true;
			$_SESSION['REQUEST_TIME'] = $when = (!empty($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time());
		}
		else
		{
			# Second or more times
			$difference = ($_SERVER['REQUEST_TIME'] - $_SESSION['REQUEST_TIME']);
			$_SESSION['REQUEST_TIME'] = $when = $_SERVER['REQUEST_TIME'];
		}

		if(($difference < $mininum_waiting) && ($is_first == false))
		{
			# You can add as many error files as you like, for different domains, or, ...
			# Reason: Might need to suppport dynamic contents

			# Most important: Some fake and blank HTML contents to be sent out.
			\common\stopper::message(file_get_contents(dirname(__FILE__) . '/error-messages/dos.attack.php') . "<!-- DIF($difference) @ {$when} - Preventing DOS Attack -->");
		}
	}
}

