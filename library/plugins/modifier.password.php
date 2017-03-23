<?php
#namespace plugins;

/**
 * Makes asterisks in a password
 */
function smarty_modifier_password($password = "")
{
    $letters = str_split($password);
    foreach ($letters as $l => $letter) {
        $letters[$l] = '*';
    }

    return implode("", $letters);
}
