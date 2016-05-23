<?php

/**
 * @package OAUTH
 * @author Arvin Castro
 * @date December 17, 2010
 * @link http://sudocode.net/sources/includes/class-xhttp-php/plugin-xhttp-cookie-php/
 */
class xhttp_cookie
{

	private static $datastore = array();

	// datastore[profile][domain][path]

	public function __construct()
	{
		// oh, nothing
	}

	public static function load()
	{
		xhttp::addHook('data-preparation', array(__CLASS__, 'apply_cookies'), 3);
		xhttp::addHook('return-response', array(__CLASS__, 'store_cookies'), 8);

		return true;
	}

	public static function clear($name = '*', $website = '*', $directory = '/')
	{
		if($name == '*' and $website == '*' and $directory == '/')
		{
			self::$datastore = array();
		}
		else
		{
			foreach(self::$datastore as $profile => &$domains) if($name == '*' or $profile == $name)
			{
				if($website == '*' and $directory == '/')
				{
					self::$datastore[$name] = array();
				}
				else
				{
					foreach($domains as $domain => &$paths) if($website == '*' or stripos($domain, $website) + strlen($website) == strlen($domain))
					{
						if($directory == '/')
						{
							self::$datastore[$profile][$domain] = array();
						}
						else
						{
							foreach($paths as $path => &$cookies) if(stripos($path, $directory) === 0)
							{
								self::$datastore[$profile][$website][$path] = array();
							}
						}
					}
				}
			}
		}
	}

	// hook: data-preparation
	public static function apply_cookies(&$urlparts, &$requestData)
	{
		$profile = (isset($requestData['profile']['name'])) ? $requestData['profile']['name'] : 'default';

		if(isset(self::$datastore[$profile]))
		{
			foreach(self::$datastore[$profile] as $domain => &$paths)
			{
				if(stripos($urlparts['host'], $domain) !== false and (stripos($urlparts['host'], $domain) + strlen($domain)) == strlen($urlparts['host']))
				{
					foreach($paths as $path => &$cookies)
					{
						if(stripos($urlparts['path'], $path) == 0
							and (!isset($cookies['expires']) or $cookies['expires'] > time())
							and (!isset($cookies['secure']) or !$cookies['secure'] or substr($urlparts['scheme'], -1) == 's')
						)
						{
							$clone = $cookies;
							unset($clone['domain'], $clone['path'], $clone['expires'], $clone['secure'], $clone['max-age']);
							$requestData['cookies'] = (array)$requestData['cookies'] + $clone;
						}
					}
				}
			}
		}
	}

	// hook: return-response
	public static function store_cookies(&$response, &$responseData)
	{
		$profile = (isset($responseData['request']['profile']['name'])) ? $responseData['request']['profile']['name'] : 'default';
		if(isset($responseData['headers']['cookies']))
		{
			$domain = $responseData['headers']['cookies']['domain'];
			$path = $responseData['headers']['cookies']['path'];
			self::$datastore[$profile][$domain][$path] = array_merge((array)self::$datastore[$profile][$domain][$path], $responseData['headers']['cookies']);
		}
	}
}
