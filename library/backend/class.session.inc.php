<?php
namespace backend;
use \common\mysql;

/**
 * Handler for Database enabled session data
 */
class session
    extends mysql
{
    /**
     * Immediately sets up the session handler
     */
    public function __construct()
    {
        parent::__construct();

        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );

        #register_shutdown_function('session_write_close');

        # Do not start_session() here. Force to use it manually
        # @see /inc/inc.config.php
    }

    /**
     * Find out, from which source to read the session data
     */
    public function open($save_path = "", $session_id = "")
    {
        #$session_id = $this->find_session_id($session_id);
        return true;
    }

    /**
     * Terminate a session
     */
    public function close()
    {
        /**
         * @todo Consider removing the session data
         * DELETE FROM query_sessions WHERE session_id="";
         */
        return true;
    }

    /**
     * Load the session variables
     * @todo menu.css seen with SQL Error: SELECT session_data sd FROM query_sessions WHERE session_id='c5ccb414c6d8c14ffb728a766244cc9d';6244cc9d';
     */
    public function read($session_id = "")
    {
        $session_id = $this->find_session_id($session_id);

        $read_session_sql = "SELECT session_data sd FROM query_sessions WHERE session_id='{$session_id}';";
        $session = $this->row($read_session_sql);

        return isset($session['sd']) ? stripslashes($session['sd']) : "";
    }

    /**
     * Encrypts a session ID: The returned session id is DETERMINISTIC.
     * The database does not store information about the ream session id,
     * but its encrypted MD5() hash.
     * It also makes the system SQL-injection-proof if bad session ids were used.
     */
    private function find_session_id($session_id = "")
    {
        $new_session_id = md5('COMPANY*' . strrev($session_id) . '#NAME');

        return $new_session_id;
    }

    /**
     * Dumps the SESSION data into the database
     */
    public function write($session_id = "", $session_data = "")
    {
        if ($session_data == "") {
            # Prevent database entry of no session data
            return true;
        } else {
            # Prevent troubles with Quotation Marks in the session data/sql
            $session_data = addslashes($session_data);
        }

        $session_id = $this->find_session_id($session_id);
        $subdomain_sql = "SELECT subdomain_id id FROM query_subdomains WHERE subdomain_name='{$_SERVER['SERVER_NAME']}';";
        $sub-domain = $this->row($subdomain_sql);
        if (!isset($subdomain['id'])) {
            $sub-domain = array('id' => 0);
        }

        $write_session_data_sql = "
INSERT INTO query_sessions (
	added_on, session_id,
	subdomain_id,
	session_data
) VALUES (
	CURRENT_TIMESTAMP(), '{$session_id}',
	{$subdomain['id']},
	'{$session_data}'
) ON DUPLICATE KEY UPDATE
	session_data = '{$session_data}'
;";

        return $this->query($write_session_data_sql);
    }

    /**
     * Permanently destroy the session data
     */
    public function destroy($session_id = "")
    {
        $session_id = $this->find_session_id($session_id);

        # Delete the session: Optional
        $delete_session_sql = "DELETE FROM query_sessions WHERE session_id='{$session_id}';";

        return $this->query($delete_session_sql);
    }

    /**
     * Garbage Collector!
     */
    public function gc($max_lifetime = 0)
    {
        # Delete the expired sessions
        # See: classes/ddl/cron.sql for details on: what to do during gc process
        # We will do the gc externally, and allow here to keep all our session data
        return true;
    }
}
