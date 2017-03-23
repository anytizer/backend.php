<?php
namespace backend;

/**
 * Access Control List and APIs
 */
class acl
	extends \common\mysql
{
	private $error;
	private $user_id = 0;

	public function __construct()
	{
		$this->error = new error('login.ini');

		parent::__construct();
	}


	/**
	 * Login a user
	 */
	public function login($username = "", $password = "")
	{
		$error = "";
		if($this->user_exists($username))
		{
			if($this->password_matches($username, $password))
			{
				if(!$this->user_expired($username))
				{
					if(!$this->user_disabled($username))
					{
						if(!$this->user_locked($username))
						{
							if($this->user_id = $this->user_id($username))
							{
							}
							else
							{
							}
							$this->update_login($username, $password);
						}
						else
						{
							$error = 'login>locked';
						}
					}
					else
					{
						$error = 'login>disabled';
					}
				}
				else
				{
					$error = 'login>expired';
				}
			}
			else
			{
				$error = 'login>unmatched';
			}
		}
		else
		{
			$error = 'login>absent';
		}

		if($error != "")
		{
			throw new \Exception($this->error->message($error));

			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Touch last login DATETIME
	 */
	private function update_login($username = "", $password = "")
	{
		$sql = "
UPDATE acl_users SET
	logged_on=CURRENT_TIMESTAMP()
WHERE
	MD5('{$username}') = `username`
	AND MD5('{$password}') = `password`
;";
		return $this->query($sql);
	}


	/**
	 * Creates a standard user
	 */
	public function create($username = "", $password = "")
	{
		if($this->user_exists($username))
		{
			# User exists already
			#return false;
			throw new \Exception($this->error->message('login>exists'));
		}
		$sql = "
INSERT INTO acl_users (
	username, password,
	expires_on, is_active,
	comments
) VALUES (
	MD5('{$username}'), MD5('{$password}'),
	UNIX_TIMESTAMP(DATE_ADD(CURRENT_DATE(), INTERVAL 2 YEAR)), 'Y',
	'{$username}'
);";
		return $this->query($sql);
	}

	/**
	 * Checks if a user exists
	 */
	private function user_exists($username = "")
	{
		$sql = "
# Validity check
SELECT COUNT(*)=1 `matched` FROM acl_users
WHERE
	MD5('{$username}') = `username`
;";
		#echo($sql);
		$record = $this->row($sql);

		#\common\stopper::debug($record, false);
		return $record['matched'];
	}

	/**
	 * Matches the password
	 */
	private function password_matches($username = "", $password = "")
	{
		$sql = "
# Password matches
SELECT COUNT(*)=1 `matched` FROM acl_users
WHERE
	MD5('{$username}') = `username`
	AND MD5('{$password}') = `password`
;";
		#echo($sql);
		$record = $this->row($sql);

		#\common\stopper::debug($record, false);
		return $record['matched'];
	}


	/**
	 * Checks if a user has expired
	 */
	private function user_expired($username = "")
	{
		$sql = "
SELECT COUNT(*)=1 matched FROM acl_users
WHERE
	MD5('{$username}') = `username`
	AND expires_on < CURRENT_TIMESTAMP()
;";
		$record = $this->row($sql);

		return $record['matched'];
	}

	/**
	 * Is the user disabled by admins?
	 */
	private function user_disabled($username = "")
	{
		$sql = "
SELECT COUNT(*)!=1 matched FROM acl_users
WHERE
	MD5('{$username}') = `username`
	AND is_active='Y'
;";
		#echo($sql);
		$record = $this->row($sql);

		return $record['matched'];
	}

	private function user_locked($username = "")
	{
		# Check somewhere to know, if a user has done some fraud activities.
		return false;
	}

	private function user_id($username = "")
	{
		$sql = "SELECT user_id FROM acl_users WHERE MD5('{$username}') = `username`;";
		if($record = $this->row($sql))
		{
		}
		else
		{
			$record = array('user_id' => 0);
		}

		return $record['user_id'];
	}

	private function group_id($group_context = "", $group_name = "")
	{
		$sql = "SELECT group_id FROM acl_groups WHERE group_code='{$group_name}' AND group_context='{$group_context}';";
		if($record = $this->row($sql))
		{
		}
		else
		{
			$record = array('group_id' => 0);
		}

		return $record['group_id'];
	}

	# Make in a group
	# insert into `acl_user_groups`(`user_id`,`group_id`) values ( '1','1')

	public function is($who = "")
	{
		$who = preg_replace('/[^a-z0-9\>\:]+/is', "", strtolower($who));
		$acl = preg_split('/\>|\:/is', $who);
		if(count($acl) < 2)
		{
			# smc>admin
			$message = 'Invalid query ' . $who;
		}
		$group_context = $acl[0];
		$group_name = $acl[1];
		$group_id = $this->group_id($group_context, $group_name);

		$sql = "
SELECT
	COUNT(*) >= 1 `member`
FROM acl_user_groups ug
INNER JOIN acl_users u ON
	u.user_id = ug.user_id
	AND u.user_id = {$this->user_id}
INNER JOIN acl_groups g ON
	g.group_id = ug.group_id
	AND ug.group_id = {$group_id}
	AND g.group_context='{$group_context}'
;";
		#echo($sql);
		$is = $this->row($sql);

		return $is['member'];
	}

	/**
	 * Can access an ACL permission?
	 */
	public function can($permission, $task)
	{
		# read, write, edit, delete
	}
}
