<?php
#namespace plugins;

/**
 * Overwrites and stores a value in the session
 * Returns in as well, because it might have been used to print.
 * For example, in the Javascripts.
 */
function smarty_modifier_remember($value = "", $key = 'captcha')
{
    $key = preg_replace('/[^a-z0-9]/is', "", $key);

    /**
     * What to remember?
     */
    if (!$value) {
        # Optionally renerate it
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
        }
    }

    /**
     * Overwrite the session key
     */
    if ($key) {
        $_SESSION[$key] = $value;
    }

    return $value;
}
