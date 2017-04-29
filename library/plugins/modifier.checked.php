<?php
#namespace plugins;

/**
 * Checkbox checked marker
 */
function smarty_modifier_checked($yn = 'N')
{
    $checked = ($yn == 'Y') ? 'checked="checked"' : "";

    return $checked;
} # checked()
