<?php
$variable->validate('get', array(
    'id' => 0,
));

$subdomain = new \subdomain\subdomains();

if ($variable->post('alias-button', 'string', "")) {
    $data = $variable->post('alias', 'array', array());

    $alias_id = isset($data['alias_id']) ? (int)$data['alias_id'] : 0;
    $subdomain_id = isset($data['subdomain_id']) ? (int)$data['subdomain_id'] : 0;

    if ($subdomain->alias($subdomain_id, $alias_id)) {
        # Success
    } else {
        # Error
    }

    # Go back to show the list of subdomains.
    \common\stopper::url('subdomains-list.php');
} else {
    # This is ID requested for making an alias.
    $subdomain_id = $variable->get('id', 'integer', 0);
    $smarty->assign('alias_id', $subdomain->alias_current($subdomain_id));
}
