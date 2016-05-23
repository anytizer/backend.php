<?php
namespace others;

/**
 * Various purpose proection
 *
 * @package Interfaces
 */
class protection
{
	private $user_id;
	private $group_id;

	private $allow_access;
	private $error_code;

	public function __construct()
	{
		$variable = new \common\variable();
		$this->user_id = $variable->session('user_id', 'integer', 0);
		$this->group_id = $variable->session('group_id', 'integer', 0);
		$this->allow_access = null;
		$this->error_code = null;

		$pc = new protection_codes();

		if($this->page_needs_protection())
		{
			if($this->user_logged_in())
			{
				if($this->session_not_expired(3))
				{
					if($this->has_permissions())
					{
						$this->allow_access = true;
					}
					else
					{
						$this->error_code = $pc->get_code('no_permissions');
					}
				}
				else
				{
					$this->error_code = $pc->get_code('session_expired');
				}
			}
			else
			{
				$this->error_code = $pc->get_code('user_not_logged_in');
			}
		}
		else
		{
			# page does not need to protect.
		}
	}

	private function page_needs_protection()
	{
		return true;

		return false;
	}

	private function user_logged_in()
	{
		return true;

		return false;
	}

	# Allow 5 minutes = 5 * 60 = 300 seconds
	private function session_not_expired($maximum_waiting = 300)
	{
		$maximum_waiting = (int)$maximum_waiting;
		$maximum_waiting = ($maximum_waiting) ? $maximum_waiting : 300;

		$difference = 0;

		$_SERVER['REQUEST_TIME'] = (!empty($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time());
		if(!empty($_SESSION['LAST_VISIT']))
		{
			# Already, there was a visit.
			$difference = $_SERVER['REQUEST_TIME'] - $_SESSION['LAST_VISIT'];
		}
		$_SESSION['LAST_VISIT'] = $_SERVER['REQUEST_TIME'];

		$session_not_expired = ($difference < $maximum_waiting);
		return $session_not_expired;
	}

	private function has_permissions()
	{
		return true;

		return false;
	}

	public function protect()
	{
		if($this->error_code)
		{
			# immediately logout the user right now...
			$variable = new \common\variable();
			$variable->kill('session');

			#\common\stopper::url('login.php');
			\common\stopper::message('Accessing protected page. Error code is: ' . $this->error_code);
		}
		else
		{
			# Do nothing. The user passed login validation :-)
		}
	}
}
