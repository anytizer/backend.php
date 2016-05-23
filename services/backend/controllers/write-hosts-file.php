<?php


\common\headers::plain();

$subdomain = new \subdomain\subdomains();
$hosts = $subdomain->get_hosts();

$lines = array();

# Add some compulsory lines here
$lines[] = '#######################################';
$lines[] = '# Put these contents in your hosts file';
$lines[] = '#######################################';

$counter = 0;
foreach($hosts as $h => $host)
{
	$lines[] = '';
	$lines[] = sprintf('# %07d. %s (ID: %d)', ++$counter, $host['comments'], $host['id']);

	# Presence of the hash sign (#) will point the URL to the live server only.
	$lines[] = (($host['hosts'] == 'N') ? '  ' : '# ') . "127.0.0.1\t{$host['name']}";
}


# These lines appear in the bottom, to effectively supress them to 127.0.0.1

# localhost
$lines[] = '';
$lines[] = "# Compulsory, for the Operating System";
$lines[] = "127.0.0.1\tlocalhost";

# This framework
$lines[] = '';
$lines[] = "# This framework application";
$lines[] = "127.0.0.1\t{$_SERVER['SERVER_NAME']}";

$hosts_file = implode("\r\n", $lines);

if(isset($_SERVER['WINDIR']))
{
	# Yes! This is a Windows Server.
	# Silently try to update windows hosts file.
	$windows_hosts_file = str_replace('%WINDIR%', $_SERVER['WINDIR'], "%WINDIR%/system32/drivers/etc/hosts");
	file_put_contents($windows_hosts_file, $hosts_file);

	# Quickly purge the DNS Resolver cache
	exec("ipconfig /flushdns");
}
else
{
	# Plan to update the linux hosts file as well.
	# This file has a different layout
	# /etc/host
}

# Show what was written to hosts file.
echo $hosts_file;
