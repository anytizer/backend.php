<?php
#namespace plugins;

/**
 * Determines if the application is running on live server
 */
function smarty_modifier_server($time = 0)
{
    $headers = new \common\headers();

    return $headers->is_server();
}
