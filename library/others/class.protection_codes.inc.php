<?php
namespace others;

/**
 * Page protection: Error codes
 *
 * @package Interfaces
 */
class protection_codes
{
	private $invalid_user = 1;
	private $invalid_group = 2;
	private $invalid_login = 3;
	private $session_expired = 4;
	private $no_permissions = 5;
	private $user_not_logged_in = 6;

	private $login_handler_not_found = 30; # absense of db login handler
	private $username_does_not_exist = 40;
	private $username_not_active = 40;
	private $username_expired = 45;
	private $password_mismatched = 45;

	public function get_code($index = '')
	{
		$value = null;
		if($index && isset($this->$index))
		{
			$value = $this->$index;
		}
		else
		{
			\common\stopper::message("Protection Code Index: {$index} NOT FOUND.");
		}

		return $value;
	}
}
