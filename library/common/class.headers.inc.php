<?php
namespace common;

/**
 * Works on $_SERVER variables
 *
 * @package Common
 */
class headers
{
	# Copy of $_SERVER array
	private $data;

	/**
	 * Clones $_SERVER variables
	 */
	public function __construct()
	{
		$this->data = $_SERVER;
	}

	/**
	 * PDF download allowed - directly from a physical file
	 *
	 * @param string $file
	 * @param string $name
	 *
	 * @return bool
	 */
	public static function pdf($file = '', $name = '')
	{
		# The file name must terminate with .pdf extension
		$success = false;
		if(is_file($file))
		{
			$name = ($name && preg_match('/\.pdf$/', $file, $data)) ? \common\tools::filename($name) : \common\tools::timestamp() . '.pdf';

			header('Pragma: public');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Pragma: no-cache');
			header('Expires: 0');
			header('Content-Transfer-Encoding: none');
			header('Content-type: application/pdf');
			header("Content-Disposition: attachment; filename=\"{$name}\"");
			header('Content-Length: ' . filesize($file));

			readfile($file);
			$success = true;
		}

		return $success;
	}

	/**
	 * Force the current stream to be downloaded.
	 * Save as a define file.
	 */
	public static function download($target_filename = 'downloaded.bin')
	{
		header('Pragma: public');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Pragma: no-cache');
		header('Expires: 0');
		header('Content-Transfer-Encoding: binary');
		header('Content-type: application/force-download');
		header("Content-Disposition: attachment; filename=\"{$target_filename}\"");
		# Stream contents after this. They will be forced to save on the client computer.
	}

	/**
	 * Plain text header
	 */
	public static function plain()
	{
		# For IE only - otherwise, it downoads a file, instead of showing it.
		$name = \common\tools::random_text(10) . '.txt';
		header('Pragma: public');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Pragma: no-cache');
		header('Expires: 0');
		header('Content-Transfer-Encoding: none');
		header('Content-Type: text/plain');
		header("Content-Disposition: inline; filename=\"{$name}\"");
	}

	/**
	 * XML Data header
	 */
	public static function xml()
	{
		header('Content-type: text/xml');
	}

	/**
	 * Files accepted by the client
	 */

	/**
	 * Send javascript headers
	 */
	public static function javascript()
	{
		self::no_cache();
		header('Content-type: text/javascript');
	}

	/**
	 * Image Headers (JPG, PNG, GIF)
	 */
	public static function image($type = '')
	{
		switch(strtolower($type))
		{
			case 'jpeg':
			case 'jpg':
				header('Content-Type: image/jpeg');
				break;
			case 'png':
				header('Content-Type: image/png');
				break;
			case 'gif':
				header('Content-Type: image/gif');
				break;
		}
	}

	/**
	 * Force caching, by expiring it in future
	 */
	public static function expire_in_future()
	{
		# In next 24 hours
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (3600 * 24)) . ' GMT');
	}

	/**
	 * Page not found error
	 */
	public static function error404()
	{
		header('Status: 404 Not Found', 404);
		header('HTTP/1.0 404 Not Found', 404);
	}

	/**
	 * Send headers not to cache the current output stream
	 */
	public static function no_cache()
	{
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');
	}

	/**
	 *
	 */
	public static function cache()
	{
		# Send some headers to force cache. each of these read-out items
		# require a lot of server resources to serve.
		$offset = 60 * 60 * 24 * 30; // one more month
		header('Cache-Control: public, must-revalidate');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT');
		header('Pragma: cache');
	}

	/**
	 * ( Matches if a request is done within this domain or not.
	 * Useful in capturing spammers without captcha
	 */
	public static function is_valid_referer()
	{
		$server_name = $_SERVER['SERVER_NAME'];

		$headers = new headers();
		$referer = $headers->referer();

		# Forum: http://www.sitepoint.com/forums/showthread.php?t=686836
		$pattern = "#^http[s]?://(?:[w]{3}+\.)?{$server_name}#";
		$is_valid_referer = (preg_match($pattern, $referer) > 0);

		return $is_valid_referer;
	}

	/**
	 * Send the proper header according to the extension of the filename
	 * All these files are referred by /css, /js and /images sections only.
	 * Not for files to be downloaded - inline only
	 *
	 * @param string $filename
	 */
	public static function headers_by_extension($filename = '')
	{
		# Send some headers to force cache. each of these read-out items
		# require a lot of server resources to serve.
		$offset = 60 * 60 * 24 * 30; // one more month
		header('Cache-Control: public, must-revalidate');
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT');
		header('Pragma: cache');

		if($names = explode('.', $filename))
		{
			$extension = strtolower($names[count($names) - 1]);
			switch($extension)
			{
				case 'jpg':
				case 'jpeg':
					header('Content-type: image/jpg');
					break;
				case 'gif':
					header('Content-type: image/gif');
					break;
				case 'png':
					header('Content-type: image/png');
					break;
				case 'css':
					header('Content-type: text/css');
					break;
				case 'js':
					header('Content-type: text/javascript');
					break;
				default:
			}
			$name = \common\tools::random_text(10) . '.' . $extension;
			header("Content-Disposition: inline; filename=\"{$name}\"");
		}
	}

	/**
	 * Send image header by analyzing the file via GD
	 *
	 * @param string $filename
	 */
	public static function headers_by_gd($filename = '')
	{
		$sizes = getimagesize($filename);
		if(isset($sizes['mime']))
		{
			header('Content-Type: ' . $sizes['mime']);
		}
	}

	/**
	 * Verifies that a url exists truly.
	 * It checks the page by opening it and reading the response code.
	 *
	 * @param string $url
	 *
	 * @return bool
	 */
	public static function url_exists($url = '')
	{
		# Articles used to create this body part:
		#   http://www.wrichards.com/blog/2009/05/php-check-if-a-url-exists-with-curl/
		#   http://css-tricks.com/snippets/php/check-if-website-is-available/

		if(!filter_var($url, FILTER_VALIDATE_URL))
		{
			return false;
		}

		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HEADER, true);
		curl_setopt($handle, CURLOPT_NOBODY, true);
		curl_setopt($handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_VERBOSE, false);
		curl_setopt($handle, CURLOPT_SSLVERSION, 3);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		$response = curl_exec($handle);
		$http_code = (int)curl_getinfo($handle, CURLINFO_HTTP_CODE);
		$url_exists = ($http_code >= 200 && $http_code < 400);
		curl_close($handle);

		return $url_exists;
	}




	/**
	 * Public interaction function
	 */

	/**
	 * Go back to the referring page or a supplied URL.
	 * Thoughts: HTTP Referrer has highest priority for admin users.
	 * Useful in admin pages that will reset the flags of the entries.
	 *
	 * @param string $url
	 */
	public static function back($url = '')
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$back_url = $_SERVER['HTTP_REFERER'];
		}
		elseif($url != '')
		{
			$back_url = $url;
		}
		else
		{
			$back_url = '/'; # Go home
		}
		die(header('Location: ' . $back_url, 301));
	}

	/**
	 * Extracts the languages the client supports
	 *
	 * @return string
	 */
	public function language()
	{
		$languages = $this->fetch('HTTP_ACCEPT_LANGUAGE');
		$languages_pattern = '/([a-z]{2})\-([A-Z]{2})/s';
		$data = array();
		preg_match_all($languages_pattern, $languages, $data);
		$language = strtoupper(isset($data[1][0]) ? $data[1][0] : 'en');

		return $language;
	}

	/**
	 * Encoding Accepted by the browser
	 *
	 * @return string
	 */
	public function encoding()
	{
		$encoding = $this->fetch('HTTP_ACCEPT_ENCODING');

		return $encoding;
	}

	/**
	 * Character Set used
	 *
	 * @return string
	 */
	public function charset()
	{
		$charset = $this->fetch('HTTP_ACCEPT_CHARSET');

		return $charset;
	}

	/**
	 * @return string
	 */
	public function accept()
	{
		$encoding = $this->fetch('HTTP_ACCEPT');

		return $encoding;
	}

	/**
	 * HTTP Browser
	 *
	 * @return string
	 */
	public function browser()
	{
		$browser = $this->fetch('HTTP_USER_AGENT');

		return $browser;
	}

	/**
	 * Returns IP or LONG IP
	 *
	 * @todo If this behaviour changes, adjust with the database.
	 * @see http://php.net/ip2long
	 *
	 * @param boolean $long_ip Whether return numeric IP or not
	 *
	 * @return int|string
	 */
	public function ip($long_ip = false)
	{
		$ip = $this->fetch('REMOTE_ADDR');

		return $long_ip === true ? (int)ip2long($ip) : $ip;
	}

	/**
	 * Returns Host Name of the browser's ISP
	 *
	 * @return string
	 */
	public function isp()
	{
		$isp = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		return $isp;
	}

	/**
	 * HTTP Referer
	 *
	 * @return string
	 */
	public function referer()
	{
		$referer = $this->fetch('HTTP_REFERER');

		return $referer;
	}

	/**
	 * Profile
	 *
	 * @return string
	 */
	public function profile()
	{
		$profile = $this->fetch('HTTP_PROFILE');

		return $profile;
	}

	/**
	 * WAP Profile
	 *
	 * @return string
	 */
	public function profile_wap()
	{
		$profile = $this->fetch('HTTP_X_WAP_PROFILE');

		return $profile;
	}

	/**
	 * Identifies if the current server is local or remote/live server.
	 * The subdomain name could be used by modifying the "hosts" file.
	 * In this case, it detects whether it is a real server or not.
	 *   TRUE  = Server is a remote machine
	 *   FALSE = Server is a local  machine
	 * Usage examples:
	 *   to enable tracking
	 *   to serve advertisements
	 *   to generate real emails
	 * The server is normally in production mode.
	 *
	 * @return bool
	 */
	public function is_server()
	{
		# In some proxy forwarded cases, the remote and server address still differ.
		# But this is a valid case of server.

		$is_server = true;

		# At the moment, we are using local server only.
		$remote_address = $this->fetch('REMOTE_ADDR');
		$server_address = $this->fetch('SERVER_ADDR');

		# See private IP addresses
		# http://en.wikipedia.org/wiki/Private_network
		# 10.0.0.0 - 10.255.255.255
		# 172.16.0.0 - 172.31.255.255
		# 192.168.0.0 - 192.168.255.255
		# 127.0.0.1
		if(preg_match('/^192\.168\./', $remote_address))
		{
			$is_server = false;
		}
		if(preg_match('/^127\.0\./', $remote_address))
		{
			$is_server = false;
		}
		if(preg_match('/^10\./', $remote_address))
		{
			$is_server = false;
		}
		if($server_address == $remote_address)
		{
			# Host and client are running on the same machine
			$is_server = false;
		}

		return $is_server;
	}

	/**
	 * Anti operation of is_server() function.
	 * Detects if the current subdomain is localhost or the one
	 * created by modifying the "hosts" file.
	 * Usage examples:
	 *   to hide tracking
	 *   to hide advertisements
	 * The server is normally in test mode.
	 *
	 * @return bool
	 */
	public function is_local()
	{
		#$remote_address = $this->fetch('REMOTE_ADDR');
		#$server_address = $this->fetch('SERVER_ADDR');
		#return $server_address == $remote_address;

		return !$this->is_server();
	}

	/**
	 * Checks out if the system is accessed via mobile devices
	 */
	public function is_mobile()
	{
		# Please build this list
		$mobiles = array(
			'android',
			'ipad',
			'iphone',
			'mobile',
			'motorola',
			'nokia',
			'opera mini',
			'sony',
			'symbian',
			'tablet',
		);
		$is_mobile = false;
		foreach($mobiles as $m => $mobile)
		{
			if(preg_match('/' . preg_quote($mobile) . '/is', $_SERVER['HTTP_USER_AGENT']))
			{
				$is_mobile = true;
				break;
			}
		}

		return $is_mobile;
	}

	/**
	 * Brings data from an index
	 *
	 * @param string $index
	 *
	 * @return string
	 */
	private function fetch($index = '')
	{
		$data = isset($this->data[$index]) ? $this->data[$index] : '';

		return $data;
	}
}
