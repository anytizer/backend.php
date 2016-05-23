<?php
$subdomain_id = $variable->get('id', 'integer', 0);
$subdomain = new \subdomain\subdomains();

$install_flag_changed = $subdomain->uninstall_subdomain($subdomain_id);
if($install_flag_changed != true)
{
	\common\stopper::url('subdomains-uninstall-error.php');
}

$self_protection_code = $subdomain->code();
#echo $self_protection_code;

$details = $subdomain->details($subdomain_id, $self_protection_code);
$smarty->assign('details', $details);
#print_r($details);

\common\stopper::url('subdomains-details.php?id=' . $subdomain_id . '&code=' . $details['code']);
