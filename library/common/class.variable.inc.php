<?php
namespace common;

/**
 * Provides a standard way to access the super globals.
 * Most probably: User Inputs: GET/POST/SESSION
 * Allows read write operations
 *
 * @package Common
 */
class variable
{
	/**
	 * Whether to continue reading a variable or not
	 */
	private $proceed;

	/**
	 * Begin with proceeding disallowed
	 */
	public function __construct()
	{
		$this->proceed = false;
	}


	/**
	 * Read out from $_GET parameters
	 *
	 * @param string $key Index Name
	 * @param string $type Data Type
	 * @param string $default Default Value, Mixed Variable
	 *
	 * @return array|bool|float|int|null|string
	 */
	public function get($key = "", $type = 'integer', $default = "")
	{
		$value = null;

		/**
		 * Check the validty of variable
		 */
		$this->proceed = isset($_GET[$key]);

		switch($type)
		{
			case 'int':
			case 'integer':
			case 'number':
			case 'numeric':
				$value = ($this->proceed) ? $this->read_integer($_GET[$key]) : 0;
				break;
			case 'float':
				$value = ($this->proceed) ? $this->read_float($_GET[$key]) : 0;
				break;
			case 'bool':
			case 'boolean':
				$value = ($this->proceed) ? $this->read_boolean($_GET[$key]) : false;
				break;
			case 'string':
				$value = ($this->proceed) ? $this->read_string($_GET[$key]) : "";
				break;
			case 'array':
				$value = ($this->proceed) ? (array)($_GET[$key]) : array();
				break;
			default:
				$this->wrong_datatype($type);
		}

		$value = $value ?? $default;

		return $value;
	}


	/**
	 * Read out from $_POST parameters
	 */
	public function post($key = "", $type = 'integer', $default = "")
	{
		$value = null;

		/**
		 * Check the validty of variable
		 */
		$this->proceed = isset($_POST[$key]);

		switch($type)
		{
			case 'int':
			case 'integer':
			case 'number':
			case 'numeric':
				$value = ($this->proceed) ? $this->read_integer($_POST[$key]) : 0;
				break;
			case 'float':
				$value = ($this->proceed) ? $this->read_float($_POST[$key]) : 0;
				break;
			case 'bool':
			case 'boolean':
				$value = ($this->proceed) ? $this->read_boolean($_POST[$key]) : false;
				break;
			case 'string':
				$value = ($this->proceed) ? $this->read_string($_POST[$key]) : "";
				break;
			case 'array':
				$value = ($this->proceed) ? (array)($_POST[$key]) : array();
				break;
			default:
				$this->wrong_datatype($type);
		}

		$value = $value ?? $default;

		return $value;
	}


	/**
	 * Read out from $_SESSION parameters
	 */
	public function session($key = "", $type = 'integer', $default = "")
	{
		$value = null;

		$this->proceed = isset($_SESSION[$key]);

		switch($type)
		{
			case 'int':
			case 'integer':
			case 'number':
			case 'numeric':
				$value = ($this->proceed) ? $this->read_integer($_SESSION[$key]) : 0;
				break;
			case 'float':
				$value = ($this->proceed) ? $this->read_float($_SESSION[$key]) : 0;
				break;
			case 'bool':
			case 'boolean':
				$value = ($this->proceed) ? $this->read_boolean($_SESSION[$key]) : false;
				break;
			case 'string':
				$value = ($this->proceed) ? $this->read_string($_SESSION[$key]) : "";
				break;
			case 'array':
				$value = ($this->proceed) ? (array)($_SESSION[$key]) : array();
				break;
			default:
				$this->wrong_datatype($type);
		}

		$value = !empty($value) ? $value : $default;

		return $value;
	}


	/**
	 * From a user supplied variable, read/extract a data
	 *
	 * @param        $variable object/integer/string/boolean passed by reference only to save memory in large objects.
	 * @param string $key
	 * @param string $type
	 * @param string $default
	 *
	 * @return array|float|int|null|string
	 */
	public function read($variable = array(), $key = "", $type = 'integer', $default = "")
	{
		$value = null;

		$this->proceed = isset($variable[$key]);

		switch($type)
		{
			case 'int':
			case 'integer':
			case 'number':
			case 'numeric':
				$value = ($this->proceed) ? (int)($variable[$key]) : 0;
				break;
			case 'float':
				$value = ($this->proceed) ? (float)($variable[$key]) : 0;
				break;
			case 'string':
				$value = ($this->proceed) ? $this->read_string($variable[$key]) : "";
				break;
			case 'array':
				$value = ($this->proceed) ? (array)($variable[$key]) : array();
				break;
			default:
				$this->wrong_datatype($type);
		}

		$value = !empty($value) ? $value : $default;

		return $value;
	}


	/**
	 * Read a variable as BOOLEAN(TRUE) [Y/N, T/F, 0/1]: Normally, we accept TRUE flags only.
	 * is_bool() tests for BOOLEAN DATA TYPE only.
	 * It can not see the value in the variable. However, we are trying to use the TRUE flag only.
	 */
	private function read_boolean($variable = false)
	{
		$success = ((is_bool($variable) && $variable === true) || $variable);

		return $success;
	}


	/**
	 * Make a variable an Integer
	 */
	private function read_integer($value = 0)
	{
		return (int)$value;
	}

	/**
	 * Make a variable an Integer
	 */
	private function read_float($value = 0.00)
	{
		return (float)$value;
	}


	/**
	 * Read a variable as SAFE string
	 */
	private function read_string($variable = "")
	{
		$variable = trim($variable);

		return $variable;
	}


	/**
	 * Writes a session, get, post
	 */
	public function write($where = 'nothing', $key = "", $value = "")
	{
		$success = true;
		switch($where)
		{
			case 'session':
				$_SESSION[$key] = $value;
				break;
			case 'post':
				$_POST[$key] = $value;
				break;
			case 'get':
				$_GET[$key] = $value;
				break;
			default:
				$success = false;
		}

		return $success;
	}


	/**
	 * Destroy a super global variable (session, get, post)
	 */
	public function kill($what = 'nothing')
	{
		$success = true;

		# Trap some errors here.
		# We may come here even without session start () like stuffs.
		if(headers_sent($filename, $line_number))
		{
			$success = false;
			die("Cannot kill variables. Headers already sent in {$filename} on line {$line_number}.");
		}

		switch($what)
		{
			case 'session':
				if(isset($_COOKIE[session_name()]))
				{
					setcookie(session_name(), "", time() - 86400, '/');
				}
				# session_destroy(); # Might be uninitialized.
				$_SESSION = array();

				/**
				 * Reset the ID: Best for database driven sessions
				 * because, new session IDs will lose a track of old data.
				 *
				 * @todo It is not possible to read the database based IDs at the moment.
				 */
				session_regenerate_id(true);
				session_id(md5(\common\tools::random_text(10)));
				break;
			case 'post':
				$_POST = array();
				break;
			case 'get':
				$_GET = array();
				break;
			case 'cookies':
				foreach($_COOKIE as $cookie => $value)
				{
					# Expiration Date in the past.
					setcookie($cookie, "", time() - 3600);
				}
				$_COOKIE = array();
				break;
			default:
				$success = false;
		}

		return $success;
	}


	/**
	 * Forgets all remembered aliases by their keys
	 *
	 * @see remember_as() method
	 * @reference Clicking on the refresh() button/link will clear the memory
	 */
	function forget($alias_key = "")
	{
		if(isset($_SESSION['REMEMBERAS'][$alias_key]))
		{
			unset($_SESSION['REMEMBERAS'][$alias_key]);
		}

		return true;
	}


	/**
	 * Remembers a POST/SESSION data with POST priorities.
	 * Next call returns the value from the SESSION, even without the POST.
	 * Warning: Explicitly works for Integers ONLY.
	 */
	public function remember($variable_index = 'remembered', $default = 0)
	{
		$value = null;
		if(!$variable_index)
		{
			return $value;
		}

		if($value = $this->post($variable_index, 'integer', 0))
		{
			$this->write('session', $variable_index, $value);
		}
		else
		{
			# Read out from the session
			if(($value = $this->session($variable_index, 'integer', 0)) == 0)
			{
				# Sorry for the zero ( 0 ), even though it was purposeful
				# For string values, use remember_string().

				# Remember the data in session to make it available in next run
				$value = (int)$default;
				$this->write('session', $variable_index, $value);
			}
		}

		return $value;
	}


	/**
	 * Remembers an ID/Numeric data from GET/POST with GET priorities.
	 * Puts the records in custom session data.
	 * Creates a session clone of the data
	 *
	 * @example $creator_id = $variable->remember_as('id', 'creator_id');
	 */
	public function remember_as($variable_index = 'remembered', $alias = "")
	{
		$value = null;
		if(!$variable_index || !$alias)
		{
			return $value;
		}

		if($value = $this->get($variable_index, 'integer', 0))
		{
			$_SESSION['REMEMBERAS'][$alias] = $value;
		}
		elseif($value = $this->post($variable_index, 'integer', 0))
		{
			$_SESSION['REMEMBERAS'][$alias] = $value;
		}
		else
		{
			# Read out from the session
			$value = isset($_SESSION['REMEMBERAS'][$alias]) ? (int)$_SESSION['REMEMBERAS'][$alias] : 0;
		}

		return $value;
	}


	/**
	 * Similar to remember() method, but works for STRING data types.
	 */
	public function remember_string($variable_index = 'index', $default = "")
	{
		$value = null;
		if(!$variable_index)
		{
			return $value;
		}

		if($value = $this->get($variable_index, 'string', ""))
		{
			$this->write('session', $variable_index, $value);
		}
		elseif($value = $this->post($variable_index, 'string', ""))
		{
			$this->write('session', $variable_index, $value);
		}
		else
		{
			# Read out from the session
			if(!($value = $this->session($variable_index, 'string', "")))
			{
				# Remember the data in session to make it available in next run
				$value = (string)$default;
			}
		}
		$this->write('session', $variable_index, $value);

		return $value;
	}


	/**
	 * Permanently traps a variable, once it is queried to access it default value.
	 * Useful in making column heads for sorting.
	 */
	public function find($variable_index = "", $default_value = "")
	{
		# GET, POST, SESSION search
		$variable = $default_value;
		if(isset($_GET[$variable_index]))
		{
			$variable = $_GET[$variable_index];
		}
		elseif(isset($_POST[$variable_index]))
		{
			$variable = $_POST[$variable_index];
		}
		elseif(isset($_SESSION[$variable_index]))
		{
			$variable = $_SESSION[$variable_index];
		}
		else
		{
			$variable = $default_value;
		}

		# Overwrite the session variable
		$_SESSION[$variable_index] = $variable;

		return $variable;
	}


	/**
	 * Makes sure that a variable has an index.
	 * It is harmless except that it may create unnecessary indices while validation was requested.
	 */
	public function validate($what = 'nothing', $params_kv = array())
	{
		switch($what)
		{
			case 'session':
				foreach($params_kv as $key => $value)
				{
					if(!isset($_SESSION[$key]))
					{
						# If there is no value existing already, create a new one.
						$_SESSION[$key] = $value;
					}
				}
				break;
			case 'post':
				foreach($params_kv as $key => $value)
				{
					if(!isset($_POST[$key]))
					{
						# If there is no value existing already, create a new one.
						$_POST[$key] = $value;
					}
				}
				break;
			case 'get':
				foreach($params_kv as $key => $value)
				{
					if(!isset($_GET[$key]))
					{
						# If there is no value existing already, create a new one.
						$_GET[$key] = $value;
					}
				}
				break;
			case 'cookies':
				foreach($params_kv as $key => $value)
				{
					if(!isset($_COOKIE[$key]))
					{
						# If there is no value existing already, create a new one.
						$_COOKIE[$key] = $value;
					}
				}
				break;
			default:
		}

		return true;
	}


	/**
	 * Ensures that a variable contains all the keys we need.
	 * If not, patch from params. Useful in assigning default values
	 */
	public function validate_variable($variable = array(), $params_kv = array())
	{
		foreach($params_kv as $key => $value)
		{
			if(!isset($variable[$key]))
			{
				# If there is no value existing already, create a new one.
				$variable[$key] = $value;
			}
		}

		return $variable;
	}


	/**
	 * When the user defined datatype is not in our consideration,
	 * stop executing the script. This is most likely due to typo error.
	 */
	private function wrong_datatype($data_type = 'unknown')
	{
		# To keep it free, do not use \common\stopper::message(), but die()
		die("Wrong data type: <strong>{$data_type}</strong>");

		return null;
	}

	/**
	 * Returns only integers from the list.
	 * @exammple $categories = $variable->validate_integers($variable->post('categories', 'array', array()));
	 */
	public function validate_integers($integers = array())
	{
		$integers = array_filter($integers, 'is_numeric');

		return $integers;
	}
}
