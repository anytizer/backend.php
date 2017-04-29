<?php
#namespace plugins;

/**
 * Puts a tick or cross icon
 *
 * @param string $is_active Y|N
 * @param int $id
 * @param string $class_name
 * @return string
 */
function smarty_modifier_tick($is_active = 'Y', $id = 0, $class_name = 'icon-tick')
{
    $id = (int)$id;
    $icon_file = ($is_active == 'Y') ? 'tick' : 'cross';
    $icon = "<img src=\"images/actions/{$icon_file}.png\" alt=\"\" title=\"\" rel=\"{$id}\" class=\"{$class_name}\" />";

    return $icon;
}
