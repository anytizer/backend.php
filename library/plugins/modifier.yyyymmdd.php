<?php
#namespace plugins;

/**
 * Converts into readable format for YYYY-MM-DD dates.
 * @example {'2010-10-04'|yyyymmdd}
 * @example 4th October, 2010 for: 2010-10-04
 */
function smarty_modifier_yyyymmdd($date = '0000-00-00', $format_type = 0)
{
    if (!preg_match('/^[\d]{4}\-[\d]{2}\-[\d]{2}$/', $date)) {
        return 'Invalid date: ' . $date;
    }

    $ymd = "";
    $months = array(
        # Default value: when 0000-00-00 cannot be read out
        # Few MySQL columns contain these types of values.
        '00' => 'Unknown',

        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    );

    $dates = explode('-', $date);

    $format_type = (int)$format_type;
    switch ((int)$format_type) {
        case 42:
            $ymd = $months[$dates[1]] . ', ' . $dates[0];
            break;
        default:
            $ordinal = new \common\ordinal();
            $ymd = ((int)$dates[2]) . '<sup>' . ($ordinal->ordinality((int)$dates[2])) . '</sup> ' . $months[$dates[1]] . ', ' . $dates[0];
    }

    return $ymd;
}
