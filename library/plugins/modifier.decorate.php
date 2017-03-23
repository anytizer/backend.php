<?php
#namespace plugins;

/**
 * ID/Code/TimestampXXXX Decorator
 * Makes sure that a code is readable as it decomposes the fundamental portions.
 */
function smarty_modifier_decorate($code = "")
{
    $data = array();
    $decorator = "";
    switch (1) {
        # Student: STYYYNNNSG
        case preg_match('/^(ST)([\d]{4})([\d]{5})(\d)([A-Z])$/', $code, $data):
            #echo("\r\nStudents: {$code}");
            $data[1] = "<strong style=\"color:#006600;\">{$data[1]}</strong>";
            $data[2] = "<strong style=\"color:#FF0000;\">{$data[2]}</strong>";
            $data[3] = "<strong style=\"color:#000099;\">{$data[3]}</strong>";
            $data[4] = "<strong style=\"color:#FF0000;\">{$data[4]}</strong>";
            $data[5] = "<strong style=\"color:#006600;\">{$data[5]}</strong>";
            break;
        # Teacher: TYYYYNNNNNGT
        case preg_match('/^(T)([\d]{4})([\d]{5})([A-Z])([A-Z])$/', $code, $data):
            #echo("\r\nTeacher: {$code}");
            $data[1] = "<strong style=\"color:#006600;\">{$data[1]}</strong>";
            $data[2] = "<strong style=\"color:#FF0000;\">{$data[2]}</strong>";
            $data[3] = "<strong style=\"color:#000099;\">{$data[3]}</strong>";
            $data[4] = "<strong style=\"color:#FF0000;\">{$data[4]}</strong>";
            $data[5] = "<strong style=\"color:#006600;\">{$data[5]}</strong>";
            break;
        # Book: BCCCCNNNNNPPP
        case preg_match('/^(B)([\d]{4})([\d]{5})([\d]{3})$/', $code, $data):
            #echo("\r\nBook: {$code}");
            $data[1] = "<strong style=\"color:#006600;\">{$data[1]}</strong>";
            $data[2] = "<strong style=\"color:#FF0000;\">{$data[2]}</strong>";
            $data[3] = "<strong style=\"color:#000099;\">{$data[3]}</strong>";
            $data[4] = "<strong style=\"color:#FF0000;\">{$data[4]}</strong>";
            break;
        # Lab Records: LSSSNNN
        case preg_match('/^(L)([\d]{3})([\d]{3})$/', $code, $data):
            #echo("\r\nLab: {$code}");
            $data[1] = "<strong style=\"color:#006600;\">{$data[1]}</strong>";
            $data[2] = "<strong style=\"color:#FF0000;\">{$data[2]}</strong>";
            $data[3] = "<strong style=\"color:#000099;\">{$data[3]}</strong>";
            break;
        # Timestamp and Random Value YYYYMMDDHHIISSXXXX
        case preg_match('/^([\d]{4})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2})([\d]{2,4})$/', $code, $data):
            #echo("\r\nTimestamp: {$code}");
            $data[1] = "<strong style=\"color:#006600;\">{$data[1]}</strong>";
            $data[2] = "<strong style=\"color:#FF00FF;\">{$data[2]}</strong>";
            $data[3] = "<strong style=\"color:#FF00FF;\">{$data[3]}</strong>";
            $data[4] = "<strong style=\"color:#FF0000;\">{$data[4]}</strong>";
            $data[5] = "<strong style=\"color:#FF0000;\">{$data[5]}</strong>";
            $data[6] = "<strong style=\"color:#FF0000;\">{$data[6]}</strong>";
            $data[7] = "<strong style=\"color:#000099;\">{$data[7]}</strong>";
            break;
        default:
            $data = array($code);
    }
    unset($data[0]);

    #print_r($data);
    return implode("", $data);
}
