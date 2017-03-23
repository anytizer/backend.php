<?php
#namespace plugins;

/**
 * Remove white spaces
 */
function smarty_modifier_tight($string = "")
{
    $string = preg_replace('/[^a-z0-9]+/is', "", $string);

    return $string;
}
