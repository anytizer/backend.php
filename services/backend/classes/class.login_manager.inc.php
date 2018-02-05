<?php
namespace subdomain;

#__DEVELOPER-COMMENTS__

# Created on: __TIMESTAMP__

/**
 * Customized login manager
 */
class login_manager
    extends \common\mysql
{
    # Flags, if a user has successfully logged on.
    private $is_logged_on = false;
    private $error_code = null; # Gives a reason for failure

    private $group_id = null; # user group ID
    private $user_id = null; # who logged in

    # Which table to access? This table should be a copy of query_users.
    # The table must have at least the following fields:
    # user_id
    # user_name
    # user_password
    # is_active
    private $user_table = 'query_users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Authenticate a user
     */
    public function login_user($username = "", $password = "")
    {
        $username = \common\tools::sanitize($username);

        # Some apps may externally verify the password
        $password = \common\tools::encrypt(\common\tools::sanitize($password));

        # Replace the table name [query_users] with your own
        $login_sql = "
SELECT
	`u`.`user_id` `user_id`,
	(COUNT(`u`.`user_id`)=1) `valid`,
	`user_password`,
	(`u`.`is_admin`='Y') `is_admin`
FROM `{$this->user_table}` `u`
WHERE
	`u`.`user_name`='{$username}'
	AND `u`.`user_password`='{$password}'
	AND `u`.`is_active`='Y'
	AND `u`.`is_approved`='Y'
GROUP BY
	`u`.`user_name`
;";
        $user = $this->row($login_sql);
        if (isset($user['valid']) && $user['valid'] == 1) {
            # Now, save the login details.
            $user['logged_on'] = true;
        } else {
            # It is important to create a nulled user.
            $user = array(
                'valid' => false,
                'logged_on' => false,
                'user_id' => null,
                'is_admin' => false,
            );
        }

        # Now, save the login details.
        $variable = new \common\variable();
        $variable->write('session', 'logged_on', $user['logged_on']);
        $variable->write('session', 'user_id', $user['user_id']);
        $variable->write('session', 'is_admin', $user['is_admin']);

        return $user['valid'];
    }

    /**
     * Log out a user and destroy all evidences of login.
     */
    public function logout_user($user_id = 0)
    {
        $variable = new \common\variable();
        $kills = array('logged_on', 'user_id', 'is_admin');
        foreach ($kills as $kill) {
            $variable->write('session', $kill, null);
            $variable->kill($kill);
        }

        return true;
    }

    /**
     * Changes a user password when old password and confirmation password match successfully for a user.
     *
     * @param int $user_id Integer User ID as probably found in the session for currently logged in user.
     * @param string $password_old Old password used by the user.
     * @param string $password_new Newly intended password.
     * @param string $password_confirm Matching confirmation of the password.
     *
     * @return int
     */
    public function password_change($user_id = 0, $password_old = "", $password_new = "", $password_confirm = "")
    {
        $user_id = (int)$user_id;

        $password_old = \common\tools::sanitize($password_old);
        $password_old = \common\tools::encrypt($password_old);

        $password_new = \common\tools::sanitize($password_new);
        $password_new = \common\tools::encrypt($password_new);

        $password_confirm = \common\tools::sanitize($password_confirm);
        $password_confirm = \common\tools::encrypt($password_confirm);

        # Encrypt the password if necessary.
        # $password_new = $this->encrypt($password_new);

        $reset_password_sql = "
UPDATE `{$this->user_table}` SET
	user_password='{$password_new}'
WHERE
	user_id='{$user_id}'
	# AND user_name='<USERNAME>'         # This is optional security
	AND user_password='{$password_old}'  # Current password matches
	AND user_password!='{$password_new}' # New password is NOT same as old one
	AND ''!='{$password_new}'            # New password is NOT blank
	AND '{$password_new}'='{$password_confirm}' # New password confirms
;";
		$this->query($reset_password_sql);

		return $this->affected_rows();
	}

    /**
     * Send a link to reset the password.
     *
     * @param string $username_email
     *
     * @return bool
     */
    public function password_forgot($username_email = "")
    {
        # Map email or username to user_name column.
        # If data exists, send a link to reset the password
        # Else, error

        return false;
    }

    /**
     * Email the users that their password were reset.
     *
     * @param int $user_id
     * @param string $new_clean_password
     *
     * @return bool
     */
    public function notify_password_changed($user_id = 0, $new_clean_password = "")
    {
        # Probably write here a script to send password and other message to the user.
        return true;
    }
}