<?php
namespace common;

/**
 * Define an index holder for different stpes of input
 */
class input
{
	private $name = 'form';

	/**
	 * @todo Fix this class file
	 */
	public function __construct()
	{
	}
	
	public function process($name = "")
	{
		if(!preg_match('/^[a-z]+$/', $name, $data))
		{
			\common\stopper::message('Invalid input name: ' . $name);
		}
		$this->name = $name;
	}

	/**
	 * reads out a key from session
	 */
	public function session($key = "")
	{
		$value = isset($_SESSION[$this->name][$key]) ? $_SESSION[$this->name][$key] : "";

		return $value;
	}

	/**
	 * Pushes valid post data into session value
	 */
	public function post2session()
	{
		if(isset($_POST[$this->name]) && is_array($_POST[$this->name]))
		{
			foreach($_POST[$this->name] as $key => $value)
			{
				# Accept reasonable only
				$_SESSION[$this->name][$key] = $value;
			}
		}
	}

	/**
	 * Flushes the session data
	 */
	public function destroy()
	{
		$_SESSION[$this->name] = array();
	}
}
