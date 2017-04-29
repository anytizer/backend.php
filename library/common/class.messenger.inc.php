<?php
namespace common;

/**
 * Communicates flash messages through session data.
 * @example `<div id="messenger">{messenger}</div>`
 */
class messenger
{
    /**
     * Colors and layout is already defined in the CSS.
     * But in worst case or just for reference, we keep them here.
     */
    private $levels = array(
        # background color, border color
        'error' => array('FFCCCC', 'FF0000'), # On errors
        'success' => array('99FFCC', '00FF00'), # On success messages
        'warning' => array('FFFFCC', 'FFFF00'), # On warnings
        'caution' => array('FFFFCC', 'FFFF00'), # On cautions
        'notice' => array('66CCFF', '99CCFF'), # On notices
        'info' => array('66CCFF', '99CCFF'), # On information
        'message' => array('66CCFF', '99CCFF'), # On messages
    );

    /**
     * One of the default available level options
     */
    private $level = 'error';

    /**
     * The message to tell
     */
    private $message = "";

    /**
     * Initiate the messenger
     */
    public function __construct($level = "", $message = "")
    {
        if (preg_match('/^[\d]{18}$/', $level)) {
            # In fact, this is a database message.
            $db = new \common\mysql();
            if ($messages = $db->row("SELECT message_status, message_body FROM query_messages WHERE message_code='{$level}';")) {
                $db->query("UPDATE query_messages SET display_counter=display_counter+1 WHERE message_code='{$level}';");
                $this->level = $messages['message_status'];
                $this->tell($messages['message_body']);

                return;
            } else {
                # Nessage not found.
            }
        }

        if ($level != "") {
            if (!in_array($level, array_keys($this->levels), false)) {
                $level = 'notice';
            }

            $this->level = $level;
        } else {
            $this->level = $this->level();
        }

        if ($message != "") {
            $this->tell($message);
        }
    }

    /**
     * Compile the message to relay
     */
    public function tell($what = "")
    {
        $this->message = $what;

        $_SESSION['messenger'] = array(
            'level' => $this->level,
            'message' => $this->message,
        );

        return true;
    }

    /**
     * Get the current level of message.
     */
    public function level()
    {
        $level = isset($_SESSION['messenger']['level']) ? $_SESSION['messenger']['level'] : "";

        return $level;
    }

    /**
     * Null the messages. Called right after relaying the messages.
     */
    public function told()
    {
        $_SESSION['messenger'] = array(
            'level' => "",
            'message' => "",
        );

        return true;
    }

    /**
     * Get the current message to relay.
     */
    public function message()
    {
        $message = isset($_SESSION['messenger']['message']) ? $_SESSION['messenger']['message'] : "";

        return $message;
    }
}
