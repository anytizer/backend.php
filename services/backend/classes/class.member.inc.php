<?php
namespace subdomain;

/**
 * A member details - handler
 */
class member
    extends \common\mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function request_membership(datatype_login $login)
    {
        # Check, if a member can continue to register.
        if (!$this->is_available($login)) {
            return false;
        }

        $tool = new \common\tools();
        $salt = $tool->random_text();

        $membership_sql = "
INSERT INTO `members_login`(
	`login_email`,
	`password_encrypted`,
	`password_salt`,
	`requested_on`, `added_on`,
	`modified_on`, `expires_on`
) VALUES (
	'{$login->email}',
	MD5(CONCAT('{$login->email}', '{$salt}', '{$login->password}')),
	'{$salt}',
	CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(),
	CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP()
);";
        #\common\stopper::debug($membership_sql, false);
        if ($this->query($membership_sql)) {
            return $salt;
        } else {
            return false;
        }
    }

    public function is_available(datatype_login $login)
    {
        $availability_sql = "
# Check, if a user can continue to register
SELECT
	COUNT(login_id)=0 available
FROM members_login
WHERE
	login_email='{$login->email}'
;";
        #\common\stopper::debug($availability_sql, false);
        $status = $this->row($availability_sql);

        #\common\stopper::debug($status, false);

        return $status['available'];
    }

    public function login(datatype_login $login)
    {
        $login_sql = "
# Login checker - match the password
SELECT
	COUNT(login_id)=1 success
FROM members_login
WHERE
	login_email='{$login->email}'
	AND expires_on >= CURRENT_TIMESTAMP()
	AND is_active='Y'
	AND password_encrypted = MD5(CONCAT(login_email, password_salt, '{$login->password}'))
;";
        #\common\stopper::debug($login_sql, false);
        $status = $this->row($login_sql);

        #\common\stopper::debug($status, false);

        return $status['success'];
    }

    public function logged_in()
    {
        $variable = new \common\variable();
        $logged_in = $variable->session('logged_in', 'boolean', false);

        return $logged_in;
    }

    public function logout(datatype_login $login)
    {
        # Remove session
        $variable = new \common\variable();
        $variable->kill('session');

        # Remove any possible cookies
        foreach ($_COOKIE as $cookie => $value) {
            setcookie($cookie, "", time() - 42000, '/');
        }
    }

    /**
     * Reads out the address book details.
     */
    public function & get_addresses($member_id = 0)
    {
        $member_id = (int)$member_id;
        $address_book_sql = "
# List of addresses
SELECT
	*
FROM members_addresses
WHERE
	login_id={$member_id}
	AND is_active='Y'
ORDER BY
	sink_weight ASC
;";
        $this->query($address_book_sql);
        $addresses = $this->to_array();

        return $addresses;
    }
}