<?php
#namespace plugins;

/**
 * UTF-8 safe HTML Entities
 */

function smarty_modifier_utf8($utf8_string = "")
{
    # ENT_IGNORE is not available on old systems.
    return htmlentities($utf8_string, ENT_QUOTES, "UTF-8");
}
