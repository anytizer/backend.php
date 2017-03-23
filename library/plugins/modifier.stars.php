<?php
#namespace plugins;

/**
 * Replaces values with asterisk. As many characters found, as many stars shown.
 *
 * @see |asterisk modifier.asterisk.php
 */
function smarty_modifier_stars($value = "")
{
    $stars = "";
    #if(is_numeric($value) && strlen($value)==1)
    if (preg_match('/^\d$/', $value)) {
        # slingle numerics
        $stars = str_repeat('&raquo;', $value);
    } else {
        $stars = preg_replace('/.?/', '*', $value);
    }

    return $stars;
}
