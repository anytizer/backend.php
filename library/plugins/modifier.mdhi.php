<?php
#namespace plugins;

/**
 * TIMESTAMP Formatter
 */
function smarty_modifier_mdhi($yyyymmddhhiiss = '0000-00-00 00:00:00')
{
    $date = $yyyymmddhhiiss;
    if (preg_match('/^[\d]{4}-[\d]{2}-[\d]{2} [\d]{2}\:[\d]{2}\:[\d]{2}$/', $yyyymmddhhiiss)) {
        # Extracts MM-DD HH:II part
        $date = substr($yyyymmddhhiiss, 5, 11);
    }

    return $date;
}
