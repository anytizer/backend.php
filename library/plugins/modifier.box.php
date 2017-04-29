<?php
#namespace plugins;

/**
 * Uses box code
 */
function smarty_modifier_box($code = "")
{
    $db = new \common\mysql();
    $code = \common\tools::safe_sql_word($code);
    $box = $db->row("SELECT * FROM query_boxes_static WHERE box_code='{$code}';");
    if (!isset($box['box_text'])) {
        $box['box_text'] = "";
    }

    return $box['box_text'];
}
