<?php
namespace abstracts;

/**
 * Login interface
 *
 * @package Interfaces
 */
abstract class login
{
	private $who;

	/**
	 * An abstract login class - begins with username/password
	 * Actually, does nothing. But simply assign $who with login_user.
	 *
	 * @param datatype_login $login_user
	 */
	abstract public function __construct(datatype_login $login_user);

	/**
	 * Validates a login
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return Boolean True/False on login success/error.
	 */
	abstract public function login_user($username = '', $password = '');

	/**
	 * Uses User ID to logout
	 */
	abstract public function logout_user($user_id = 0);

	/**
	 * Change a password
	 *
	 * @param int    $user_id
	 * @param string $password_new
	 * @param string $password_old
	 *
	 * @return mixed
	 */
	abstract public function password_change($user_id = 0, $password_new = '', $password_old = '');

	/**
	 * Password forgotten. Send an email.
	 *
	 * @param string $username_email
	 *
	 * @return mixed
	 */
	abstract public function password_forgot($username_email = '');
}
