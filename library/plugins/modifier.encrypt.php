<?php
#namespace plugins;

/**
 * Encrypts a string
 * Usage Example: Transferring over $_GET
 * @todo Find usages
 */
function smarty_modifier_encrypt($string = "")
{
    $string = base64_encode(htmlentities($string));

    return $string;
}
