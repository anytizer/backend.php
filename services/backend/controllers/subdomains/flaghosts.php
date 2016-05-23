<?php
/**
 * Flags hosts paramter
 */

$subdomain_id = $variable->get('id', 'integer', 0);
$code = $variable->get('code', 'string', ''); # For future references

$subdomains = new \subdomain\subdomains();
$subdomains->flag_hosts($subdomain_id, $code);

\common\headers::back('subdomains-list.php');
