<?php
namespace common;

/**
 * Database enabled error handling
 */
class error_handler
{
    public function __construct()
    {
        $old_error_handler = set_error_handler(array(&$this, 'handler'));
    }

    public function handler($error_no = 0, $error_message = "", $file_name = "", $line_number = 0, $variables = array())
    {
        # Validation
        $error_no = (int)$error_no;
        $line_number = (int)$line_number;
        $error_message = addslashes($error_message);
        $file_name = addslashes($file_name); # Only for windows
        #\common\stopper::message($error_message);
        #\common\stopper::message3($file_name);

        #\common\stopper::debug($variables, false); \common\stopper::message();
        $variables = array(); # Sorry, but we can not store all the variables there.
        # Rather, we can customize, if a session/user id exists.

        $variables_text = serialize($variables);

        $error_save_sql = "
INSERT INTO `query_errors`(
	`error_on`,
	`error_no`, `file_name`, `line_num`,
	`variables`,
	`error_message`
) VALUES (
	CURRENT_TIMESTAMP(),
	{$error_no}, '{$file_name}', {$line_number},
	'{$variables_text}',
	'{$error_message}'
);";
        #echo($error_save_sql);
        $db = new \common\mysql();

        return $db->query($error_save_sql);
    }
}

/*
# Examples
$error = new error_handler(); # Database enabled error handling
trigger_error("Sorry...", E_USER_WARNING);
*/
