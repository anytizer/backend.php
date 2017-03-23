<?php
#namespace plugins;

/**
 * Formats the time() numbers for readability.
 *
 * @param $time Integer The time() value
 * @param $format_type Integer The type of date to format in switch/case block
 *
 * @return String formatted and readable date
 */
function smarty_modifier_ymd($time = 0, $format_type = 0)
{
    $ymd = 'N/A';

    # It is normally of 10 digits, e.g.: 1287564900
    # SELECT LENGTH(UNIX_TIMESTAMP(CURRENT_TIMESTAMP())) `length`;
    # if($time==0 || preg_match('/^[^\d]+$/is', $time))
    if (!preg_match('/^[\d]{10}$/is', $time) || $time == 0) {
        return $ymd;
    }

    $format_type = (int)$format_type;
    switch ((int)$format_type) {
        case 50:
            $ymd = date('d/m H:i', $time);
            break;
        case 40:
            # If the current date is today - just print out the time part
            $date = date('Y-m-d', $time);
            if ($date != date('Y-m-d')) {
                # Old dates - hence - date part only
                $ymd = $date;
            } else {
                # Today! Hence, time part only
                # This may help to tract the list of transactions done today
                #$ymd = date('h:i:s A', $time);
                $ymd = date('H:i:s', $time);
            }
            break;
        case 41:
            # Work on this year only
            # If the current date is today - just print out the time part
            $date = date('d M', $time);
            $ymd = ($date != date('d M')) ? $date : date('H:i', $time);
            break;
        case 42:
            # Year month processing
            $date = date('M Y', $time);
            $ymd = ($date != date('M Y')) ? $date : 'this month';
            break;
        case 43:
            # eg. 16 Jun 2012
            $ymd = date('d M Y', $time);
            break;
        case 44:
            # eg. 16 June 2012
            $ymd = date('d F Y', $time);
            break;
        case 30:
            # Converts to Full date/time format
            # eg. 2012-08-21 15:45:20
            $ymd = date('Y-m-d H:i:s', $time);
            break;
        case 10:
            # HTML Formatted: 20th October, 2010 (Friday)
            $ymd = date('j', $time) . '<sup>' . date('S', $time) . '</sup>' . date(' F, Y', $time) . date(' (l)');
            break;
        case 20:
            # HTML Formatted: 20th October, 2010 (Friday)
            $ymd = date('Y-m-d', $time);
            break;
        case 0:
        default:
            $ymd = date('jS F, Y', $time);
    }

    # Other formats:
    # jS F, Y (l) => 20th October, 2010 (Friday)
    # jS F (l), Y => 20th October (Friday), 2010
    # jS F, Y     => 20th October, 2010
    return $ymd;
}
