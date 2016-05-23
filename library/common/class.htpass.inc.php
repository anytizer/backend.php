<?php
namespace common;

/**
 * Generates HTTP Password for Apache Enabled websites.
 */
class htpass
{
	public $users;
	public $password_level;

	public function __construct($password_level = 0)
	{
		$this->users = array();
		$this->password_level = (is_numeric($password_level) && $password_level <= 4) ? $password_level : 0;
	}


	/**
	 * Add a valid user/password in the list
	 */
	public function add_user($user_name = '', $password = '')
	{
		if(preg_match('/^[a-z]+$/im', $user_name))
		{
			$this->users[] = array($user_name, $this->get_password($password, $this->password_level));

			return true;
		}

		return false;
	}

	public function get_password($string = '', $password_level = 0)
	{
		# Different servers may support password encryption techiques.
		# Go through hits and trails.

		$password = '';
		switch($password_level)
		{
			case 0:
				$password = $this->easy_password($string);
				break;
			case 1:
				$password = $this->crypted($string);
				break;
			case 2:
				$password = $this->rand_salt_crypt($string);
				break;
			case 3:
				$password = $this->rand_salt_sha1($string);
				break;
			case 4:
			default:
				$password = $this->non_salted_sha1($string);
				break;
		}

		return $password;
	}

	public function save($protection_name = 'Protected Area')
		#, $location='./')
	{
		# .htpasswd
		$users_lines = array(); # For .htaccess listing
		$passwords = array();
		foreach($this->users as $i => $user)
		{
			$passwords[] = "{$user[0]}:{$user[1]}";
			$users_lines[] = "require user {$user[0]}";
		}

		#$dir = is_dir($location)?$location:dirname($_SERVER['SCRIPT_FILENAME']);
		$dir = dirname($_SERVER['SCRIPT_FILENAME']);

		$protection_name = addslashes($protection_name);
		$htaccess = "
AuthUserFile {$dir}/.htpasswd
AuthGroupFile /dev/null
AuthName \"{$protection_name}\"
AuthType Basic

<LIMIT GET PUT POST>
" . implode("\n", $users_lines) . "
require valid-user
</LIMIT>
";
		#.htppasswd
		file_put_contents($dir . '/.htpasswd', implode("\n", $passwords), $htaccess, FILE_APPEND);

		#.htaccess
		file_put_contents($dir . '/.htaccess', $htaccess, FILE_APPEND);

		# $_SERVER['SCRIPT_FILENAME']
		# $_SERVER['SCRIPT_NAME']
		#\common\stopper::message(dirname($_SERVER['SCRIPT_FILENAME']));
		#\common\stopper::debug($_SERVER, false);
	}

	//encryption functions

	public function easy_password($string = '')
	{
		return $string;
	}

	public function crypted($string = '')
	{
		$password = crypt($string, base64_encode($string));

		return $password;
	}

	public function rand_salt_crypt($string = '')
	{
		$salt = "";
		mt_srand((double)microtime() * 1000000);
		for($i = 0; $i < CRYPT_SALT_LENGTH; $i++)
			$salt .= substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789./", mt_rand() & 63, 1);

		return "$apr1$" . crypt($string, $salt);
	}

	public function rand_salt_sha1($string = '')
	{
		mt_srand((double)microtime() * 1000000);
		$salt = pack("CCCC", mt_rand(), mt_rand(), mt_rand(), mt_rand());

		return "{SSHA}" . base64_encode(pack("H*", sha1($string . $salt)) . $salt);
	}

	public function non_salted_sha1($string = '')
	{
		return "{SHA}" . base64_encode(pack("H*", sha1($string)));
	}
}

