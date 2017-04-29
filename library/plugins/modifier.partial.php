<?php
#namespace plugins;

/**
 * Partially show up the long text (cutting off in the middle)
 * Useful in printing long directory names
 */
function smarty_modifier_partial($string = "", $acceptable_length = 50)
{
    $partial = "";
    $string = strip_tags($string);

    if (($length = strlen($string)) > $acceptable_length) {
        # Cut off length should be EVEN
        $cutoff_length = floor($length - $acceptable_length);
        if ($cutoff_length % 2 != 0) {
            ++$cutoff_length;
        }
        $mid = floor($length / 2);

        $left = substr($string, 0, $mid - $cutoff_length / 2);
        $right = substr($string, $mid + $cutoff_length / 2);
        $partial = $left . '...' . $right;
    } else {
        $partial = $string;
    }

    return $partial;
}
