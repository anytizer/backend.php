<?php
#namespace plugins;

/**
 * Prints an HTML output of the address entity. Useful in managing the users and membership details.
 */
function smarty_modifier_address($value = "", $field = "", $separator = ': ', $EOL_separator = '<br />')
{
    $html = "";
    if ($value) {
        if ($field) {
            $html = $field . $separator . $value . $EOL_separator;
        } else {
            $html = $value . $EOL_separator;
        }
    }

    return $html;
}
