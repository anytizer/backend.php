<?php
namespace others;

/**
 * Data Type for a member's login details
 *
 * @package Interfaces
 */
class datatype_login
	extends \abstracts\datatype
{
	/**
	 * Set the variables properly
	 */
	public function __construct($username = '', $password = '')
	{
		parent::__construct(array(
			'username',
			'password'
		));

		$this->username = \common\tools::sanitize($username);
		$this->password = \common\tools::sanitize($password);
	}

	/**
	 * See, if this data type is good to use.
	 */
	public function is_valid()
	{
		$is_valid = (!empty($this->username) && !empty($this->password));
		return $is_valid;
	}
}
