<?php
$subdomain_id = $variable->get('id', 'integer', 0);

$subdomain = new \subdomain\subdomains();
if ($subdomain->install_subdomain($subdomain_id) === true) {
    # 100% chance that flow controller will come here.
    #\common\stopper::url('subdomains-install-successful.php');
} else {
    \common\stopper::url('subdomains-install-error.php');
}
