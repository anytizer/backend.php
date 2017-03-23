<?php
#namespace plugins;

/**
 * Magical value reader
 * Searching for an existing indexed value on $_POST, $_GET, $_SESSION, $_COOKIE.
 * Makes sure that the return value is always a string.
 */
function smarty_modifier_magical($variable_index = "", $save_for_future = true, $overwrite_value = false)
{
    $value = "";

    # Optional, for enhancing safety
    $variable_index = preg_replace('/[^a-z0-9\_]+/i', "", $variable_index);

    switch (true) {
        case isset($_POST[$variable_index]):
            # Highest order
            $value = $_POST[$variable_index];
            break;
        case isset($_GET[$variable_index]):
            # Most frequent chance
            $value = $_GET[$variable_index];
            break;
        case isset($_SESSION[$variable_index]):
            # Average chance
            $value = $_SESSION[$variable_index];
            break;
        case isset($_COOKIE[$variable_index]):
            # Least used
            $value = $_COOKIE[$variable_index];
            break;
        default:
    }

    if ($save_for_future === true) {
        #if(isset($_SESSION[$variable_index])
        {
            # Do not disturb the current value, if set
            $_SESSION[$variable_index] = $value;
        }
    }

    # Convert it into string and return.
    return "{$value}";
}
