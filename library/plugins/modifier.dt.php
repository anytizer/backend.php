<?php
#namespace plugins;

/**
 * Formats a date string through out the website
 * If $date is missing, it will format the current time
 *
 * @example {'m/d H:i'|date}
 * @example {'m/d H:i'|date:1344314963}
 */
function smarty_modifier_dt($format_string = 'm/d/Y', $date = 0)
{
    if (!$format_string) {
        $format_string = 'm/d/Y';
    }
    if (!$date) {
        $date = time();
    }

    return date($format_string, $date);
}
