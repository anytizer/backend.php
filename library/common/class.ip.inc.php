<?php
namespace common;

/**
 * IP range calculator - useful in range specific operations.
 *
 * @package Common
 */
class ip
{
	private $ip;

	public function __construct($ip = '0.0.0.0')
	{
		if(!$ip || $ip == '0.0.0.0')
		{
			if(isset($_SERVER['REMOTE_ADDR']))
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		$this->ip = $ip;
	}

	function lower($is_long = false)
	{
		$first = preg_replace('/\.[\d]+$/', '.0', $this->ip);

		return $is_long ? ip2long($first) : $first;
	}

	function upper($is_long = false)
	{
		$last = preg_replace('/\.[\d]+$/', '.255', $this->ip);

		return $is_long ? ip2long($last) : $last;
	}

	public function long_ip($ip = "")
	{
		if(!$ip)
		{
			$ip = $this->ip;
		}

		return sprintf("%u", ip2long(long2ip(ip2long($ip))));
	}

	public function get_ip($long_ip = 0)
	{
		return long2ip($long_ip);
	}
}

