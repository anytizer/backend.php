<?php
#namespace plugins;

/**
 * Validates an input value to numerical/integer
 */
function smarty_modifier_numeric($value = 0)
{
    $value = (int)$value;

    return $value;
}
