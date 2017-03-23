<?php
namespace common;

/**
 * member types: admin, company, member, user, guest
 */
class logger
{
    /**
     * Types of the uses that can login.
     */
    public $allowed_types;
    private $index = 'logger'; # a name of session to lock/logger

    public function __construct()
    {
        # examples
        # guest, user, member, admin, superadmin, company
        $this->allowed_types = array(
            'admin',
            'company',
            'member',
            'user',
            'guest',
            # ... add more ...
            # Must be synchronized with session, database and permission names.
        );

        foreach ($this->allowed_types as $i => $user_type) {
            # Set all variables needed.
            if (!isset($_SESSION[$this->index][$user_type])) {
                $_SESSION[$this->index][$user_type] = false;
            }
        }
    }

    /**
     * Mark as logged in, for a user type
     */
    public function login($who = 'guest')
    {
        $logger = $this->get_logger($who);
        $_SESSION[$this->index][$logger] = true;
    }

    /**
     * switch/case for fixing hack attempts
     */
    public function get_logger($who = 'guest')
    {
        $who = strtolower(trim($who));
        $logger = (in_array($who, $this->allowed_types, true)) ? $who : 'guest';

        return $logger;
    }

    /**
     * Throw a login of a user type
     */
    public function logout($who = 'guest')
    {
        $logger = $this->get_logger($who);
        $_SESSION[$this->index][$logger] = false;
        #unset($_SESSION['login'][$logger]);
    }

    /**
     * Stop the session now
     */
    public function terminate()
    {
        # Remove session
        $_SESSION = array();

        # Remove any possible cookies
        foreach ($_COOKIE as $cookie => $value) {
            setcookie($cookie, "", time() - 42000, '/');
        }

        session_destroy();
    }

    public function allow_only($loggers = 'guest') # csv: guest, member, admin
    {
        $success = false;

        #$loggers_all = explode(',', $loggers);
        $loggers_all = preg_split('/[\,\;\:\|\/\ ]/', $loggers, -1, PREG_SPLIT_NO_EMPTY);
        $loggers_all = array_map('trim', $loggers_all);
        $loggers_all = array_map('strtolower', $loggers_all);
        #\common\stopper::debug($loggers_all, true);

        # Allow multiple types
        #\common\stopper::debug('multiple types of members', true);
        foreach ($loggers_all as $i => $logger) {
            if ($this->is_logged_in($logger)) {
                #\common\stopper::debug($logger.' has logged in', true);
                $success = true;
            }
        }

        # Stop the page now
        if ($success != true) {
            if (count($loggers_all) == 1) {
                \common\stopper::debug("Restricted area for <strong>{$loggers_all[0]}</strong> only", true);
            } else {
                \common\stopper::debug("Restricted area for logged in users only. Types needed: <strong>" . implode(', ', $loggers_all) . "</strong>", true);
            }
        }

        return $success;
    }

    /**
     * Check if a particular user type has logged in.
     */
    public function is_logged_in($who = 'guest')
    {
        $logger = $this->get_logger($who);

        return isset($_SESSION[$this->index][$logger]) && ($_SESSION[$this->index][$logger] === true);
    }
}
