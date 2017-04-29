<?php
#namespace plugins;

/**
 * Put an icon for various use.
 * Use <img> tags as well, when necessary.
 */
function smarty_modifier_icon($value = 'N', $context = 'YN')
{
    $icon_name = "";
    if (!in_array($value, array('N', 'Y', 'D'))) {
        # requesting src="..." only
        $src = "images/selected-icons/{$value}.png";

        return $src;
    }

    switch (strtoupper($context)) {
        case 'YN': # Yes/No Icon, ticks/cross
            $icon_name = ($value == 'Y') ? 'tick' : 'cross';
            break;
        default:
    }

    # Full image is requested via plugins for tick/cross
    $icon = "<img src=\"images/selected-icons/{$icon_name}.png\" />";

    return $icon;
}
