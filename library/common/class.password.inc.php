<?php
namespace common;

/**
 * Zen-cart compatible password management
 *
 * @package Common
 */
class password
{
	private $salt_length = 2;

	/**
	 * Begin password
	 */
	public function __construct($salt_length = 0)
	{
		if($salt_length = (int)$salt_length)
		{
			$this->salt_length = $salt_length;
		}
	}

	/**
	 * Return a random value
	 */
	private function random($min = null, $max = null)
	{
		static $seeded;
		if(!$seeded)
		{
			mt_srand((double)microtime() * 1000000);
			$seeded = true;
		}

		if(isset($min) && isset($max))
		{
			if($min >= $max)
			{
				return $min;
			}
			else
			{
				return mt_rand($min, $max);
			}
		}
		else
		{
			return mt_rand();
		}
	}

	/**
	 * Exact copy of zen (front end password encrypt)
	 */
	public function encrypt_password($plain = '')
	{
		$password = '';
		for($i = 0; $i < 10; $i++)
		{
			$password .= $this->random();
		}

		$salt = substr(md5($password), 0, $this->salt_length);
		$password = md5($salt . $plain) . ':' . $salt;

		return $password;
	}

	/**
	 * Validates a plain text password with an encrpyted password
	 */
	public function validate_password($plain = '', $encrypted = '')
	{
		# if password match fails, you might have supplied encrypted password instead of plain password.
		#die("Plain: {$plain}, Encrypted Match: {$encrypted}");
		if($this->not_null($plain) && $this->not_null($encrypted))
		{
			# split apart the hash / salt
			$stack = explode(':', $encrypted);

			# We need exctly 2 parts in the password.
			if(count($stack) != 2)
			{
				return false;
			}

			# The salt length must be same.
			if(strlen($stack[1]) != $this->salt_length)
			{
				return false;
			}

			# Yes, the real password match is here.
			if(md5($stack[1] . $plain) == $stack[0])
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * A modified copy of zen password checker
	 */
	private function not_null($value)
	{
		if(is_array($value))
		{
			if(count($value) > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			/**
			 * @todo Smelly code
			 */
			if((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}
