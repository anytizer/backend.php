<?php
namespace third;

/**
 * whois checker
 */
class whois_checker
{
	private $url = 'http://reports.internic.net/cgi/whois?type=domain&whois_nic=__DOMAIN__';
	private $find = 'Expiration Date:';
	private $method = 'get';

	private $domain = "";

	public function is_registered($domain = 'domain.com')
	{
		$is_registered = false;
		$domain = strtolower($domain);
		$domains = explode('.', $domain);
		$last = $domains[count($domains) - 1];
		switch($last)
		{
			case 'us':
				break;
			case 'aero':
			case 'arpa':
			case 'asia':
			case 'biz':
			case 'cat':
			case 'com':
			case 'coop':
			case 'edu':
			case 'info':
			case 'int':
			case 'jobs':
			case 'mobi':
			case 'museum':
			case 'name':
			case 'net':
			case 'org':
			case 'pro':
			case 'travel':
				$whois = new whois_internic($domain);
				$is_registered = $whois->is_registered();
				#print_r($domains);
				#print_r($whois);
				#echo 'Checking on Internic/WHOIS: '.$domain;
				break;
			default:
				#echo 'We cannot check domain: '.$domain.': '.$last;
				break;
		}

		return $is_registered;
	}
}
