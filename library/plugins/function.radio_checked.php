<?php
#namespace plugins;

/**
 * A reusable component to check HTML radios and check boxes
 */
function smarty_function_radio_checked($params = array(), &$smarty)
{
# Examples:
# $_GET['mobile'] => xx as force, then, select it.
# {radio_checked force='mobile'}
# {radio_checked value='$v' compare='Y'}

# force / value|compare are mutually exclusive

    $checked = "";
    $params['mode'] = !empty($params['mode']) ? $params['mode'] : 'checked'; # checked / selected

    $params['force'] = !empty($params['force']) ? $params['force'] : "";
    if ($params['force'] != "" && !empty($_GET[$params['force']])) {
        $checked = "{$params['mode']}=\"{$params['mode']}\"";
    } else {
        # Otherwise, value compare it and select it.
        $params['value'] = !empty($params['value']) ? $params['value'] : "";
        $params['compare'] = !empty($params['compare']) ? $params['compare'] : "";
        if ($params['value'] && $params['compare']) {
            $checked = ($params['value'] == $params['compare']) ? "{$params['mode']}=\"{$params['mode']}\"" : "";
        }
    }

    return $checked;
} # radio_checked()
