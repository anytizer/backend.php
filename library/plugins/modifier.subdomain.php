<?php
#namespace plugins;

/**
 * Finds out a sub-domain name by its ID
 */
function smarty_modifier_subdomain($subdomain_id = 0)
{
    $subdomain_id = (int)$subdomain_id;

    $db = new \common\mysql();
    $sub-domain = $db->row("SELECT subdomain_name FROM query_subdomains WHERE subdomain_id={$subdomain_id};");
    if (!isset($subdomain['subdomain_name'])) {
        $sub-domain = array('subdomain_name' => 'N/A');
    }

    return $subdomain['subdomain_name'];
}
