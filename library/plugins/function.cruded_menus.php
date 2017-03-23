<?php
#namespace plugins;

/**
 * On menus bar, displays the CRUDed lists
 */
function smarty_function_cruded_menus($params = array(), &$smarty)
{
    global $subdomain_id;
    $params['admin'] = isset($params['admin']) ? $params['admin'] === true : false;

    $cruded_sql = "SELECT full_name, crud_name FROM query_cruded WHERE subdomain_id={$subdomain_id} AND crud_name!='' AND is_active='Y' AND is_approved='Y';";
	$db = new \common\mysql();
	$db->query($cruded_sql);
	$links = array();
	while ($db->next_record()) {
        if ($params['admin']) {
            # Admin area links
            $links[] = "<li><a href='{$db->row_data['crud_name']}-list.php'>{$db->row_data['full_name']}</a></li>";
        } else {
            # Front end links
            $links[] = "<li><a href='{$db->row_data['crud_name']}.php'>{$db->row_data['full_name']}</a></li>";
        }
    }

	return implode("", $links);
} # cruded()
