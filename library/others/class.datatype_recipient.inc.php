<?php
namespace others;

/**
 * Data Type for an email address (Name <email>)
 *
 * @package Interfaces
 */
class datatype_recipient
	extends \abstracts\datatype
{
	/**
	 * Set the variables properly
	 */
	public function __construct($email = '', $name = '')
	{
		parent::__construct(array(
			'email',
			'name',
		));

		$this->email = \common\tools::sanitize($email);
		$this->name = \common\tools::sanitize($name);
	}

	/**
	 * If the current object holds valid email and name?
	 */
	public function is_valid()
	{
		# Validate name
		$success = ($this->name != '' && $this->email != '');

		# Add more validation here...
		# ...

		# Finally, return the status
		return $success;
	}
}
