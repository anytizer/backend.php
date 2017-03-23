<?php
namespace backend;

/**
 * Intelligently create mysql users
 */
class mysqluser
	extends \common\mysql
{
	private $username = "";
	private $hostname = "";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create a new user
	 */
	public function create_user($hostname = "", $username = "", $password = "")
	{
		# Mark who was last used
		$this->username = $username;
		$this->hostname = $hostname;

		if($this->user_exists($hostname, $username))
		{
			return true;
		}
		else
		{
			$this->user_create($hostname, $username, $password);
		}

		return true;
	}

	/**
	 * Allow access to the database
	 */
	public function allow_database($database_name = "")
	{
		$create_sql = "CREATE DATABASE IF NOT EXISTS `{$database_name}` CHARACTER SET utf8 COLLATE utf8_general_ci;";
		#$permissions_sql="GRANT USAGE ON `{$database_name}`.* TO '{$this->username}'@'{$this->hostname}';";
		$permissions_sql = "GRANT ALL ON `{$database_name}`.* TO '{$this->username}'@'{$this->hostname}';";

		$this->query($create_sql);
		$this->query($permissions_sql);

		return true;
	}

	/**
	 * Check if a user exist
	 */
	private function user_exists($hostname = "", $username = "")
	{
		$user_exists = false;
		$check_user_sql = "SELECT `Host`, `User` FROM mysql.user WHERE `User`='{$username}' AND `Host`='{$hostname}';";
		if($user = $this->row($check_user_sql))
		{
			$user_exists = true;
		}

		return $user_exists;
	}

	/**
	 * Create a single user
	 */
	private function user_create($hostname = "", $username = "", $password = "")
	{
		$create_sql = "CREATE USER '{$username}'@'{$hostname}' IDENTIFIED BY '{$password}';";
		$this->query($create_sql);

		#$password_sql="SET PASSWORD FOR '{$username}'@'{$hostname}' = PASSWORD('{$password}');";
		#$this->query($password_sql);

		$flush_sql = "FLUSH PRIVILEGES;";
		$this->query($flush_sql);

		return true;
	}


	# Overrite the MySQL::Query for debugging
	public function query($sql = "")
	{
		echo $sql, "\r\n";

		return parent::query($sql);
	}
}

