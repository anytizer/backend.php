<?php
#namespace plugins;

/**
 * HTML PRE writing
 * @todo Find the usage or remove
 *
 * @link http://www.smarty.net/forums/viewtopic.php?p=78611
 */
function smarty_modifier_pre($html = "", $nl2br = 'N')
{
    if ($nl2br === 'Y' || $nl2br === true) {
        return nl2br($html);
    } else {
        return '<pre>' . $html . '</pre>';
    }
}
