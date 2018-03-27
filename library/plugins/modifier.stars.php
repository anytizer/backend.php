<?php
#namespace plugins;

/**
 * Replaces values with asterisk. As many characters found, as many stars shown.
 *
 * @see |asterisk modifier.asterisk.php
 * @todo Write tests
 */
function smarty_modifier_stars($value = "")
{
    $stars = "";
    if (preg_match('/^\d$/', $value)) {
        $stars = str_repeat('&raquo;', $value);
    } else {
        $stars = preg_replace('/.?/', '*', $value);
    }

    return $stars;
}
