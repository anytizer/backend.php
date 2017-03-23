<?php
namespace common;

/**
 * Fetches a page with cURL library.
 * Warning: Make a directory to save the cookie, cookie jar, and browsed files.
 * @uses `__TEMP_PATH__`
 * @package Common
 */
class curl
{
	private $curl_reference;
	private $cookie_file;

	/**
	 * @todo App's temp path in use
	 * @todo Remove parameterised custm values and make another method for this.
	 */
	public function __construct($custom = array())
	{
		$COOKIE_ID = !empty($_COOKIE['COOKIE_ID']) ? $_COOKIE['COOKIE_ID'] : md5(microtime());

		# for CRON scripts that work without the framework
		$this->cookie_file = __TEMP_PATH__.'/curl-cookies-' . $COOKIE_ID . '.cookie';

		$this->initialize($custom);
	}

	/**
	 * Set an individual curl parameter. Every declaration is a defined constant.
	 * Do NOT send identifier as string. Rather use their defined CONSTANTs.
	 *
	 * @param string $identifier
	 * @param string $value
	 *
	 * @return bool
	 */
	public function set_option($identifier = "", $value = "")
	{
		/**
		 * @todo Check for usage; code smell?
		 */
		if(preg_match('/^[\d]+$/', $value))
		{
			$value = (int)$value;
		}

		/**
		 * Identifier should always be a defined constant that is useful for CURL.
		 */
		if(!preg_match('/^[\d]+$/', $identifier))
		{
			# Otherwise, search, if the CURL CONSTANT exists.
			if(defined($identifier))
			{
				$identifier = constant($identifier);
			}
			else
			{
				return false;
			}
		}

		return curl_setopt($this->curl_reference, $identifier, $value);
	}

	/**
	 * Actually fetch contents from the page.
	 * Return the contents.
	 *
	 * @return mixed
	 */
	public function execute()
	{
		return curl_exec($this->curl_reference);
	}

	/**
	 * Close curl fetching and remove the cookie file
	 *
	 * @param bool $delete_file
	 *
	 * @return bool
	 */
	public function free($delete_file = false)
	{
		curl_close($this->curl_reference);

		if($delete_file)
		{
			$this->delete_cookies();
		}

		return true;
	}

	/**
	 * Read the page contents with GET
	 *
	 * @param string $url
	 * @param array  $data
	 *
	 * @return mixed
	 */
	public function get($url = "", $data = array())
	{
		$post_data = $this->fix_array($data);
		$url = ($post_data != "") ? $url . '?' . $post_data : $url;

		return $this->get_url($url);
	}

	/**
	 * @param string $link
	 * @param array  $data is an associative array.
	 *
	 * @return mixed
	 */
	public function post($link = "", $data = array())
	{
		$post_data = $this->fix_array($data);

		$page = $this->post_url($link, $post_data);

		return $page;
	}

	/**
	 * @return mixed
	 */
	public function get_header()
	{
		return curl_getinfo($this->curl_reference);
	}

	/**
	 * Sets the standard default CURL options
	 * @see http://php.net/manual/en/function.curl-setopt.php
	 *
	 * @param array $custom
	 *
	 * @return bool
	 */
	private function initialize($custom = array())
	{
		$this->curl_reference = curl_init();

		$this->set_option(CURLOPT_VERBOSE, false);
		$this->set_option(CURLOPT_TIMEOUT, 50);
		$this->set_option(CURLOPT_CONNECTTIMEOUT, 50);
		$this->set_option(CURLOPT_RETURNTRANSFER, true);
		$this->set_option(CURLOPT_SSL_VERIFYPEER, false);
		$this->set_option(CURLOPT_SSL_VERIFYHOST, false);
		$this->set_option(CURLOPT_COOKIEJAR, $this->cookie_file);
		$this->set_option(CURLOPT_COOKIEFILE, $this->cookie_file);

		/**
		 * Remove this block as app already validates it
		 */
		if(!isset($_SERVER['HTTP_USER_AGENT']))
		{
			$_SERVER['HTTP_USER_AGENT'] = 'cURL@backend';
		}
		$this->set_option(CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); # CLIENT_HTTP_AGENT);

		# Error: cannot be activated when in safe_mode or an open_basedir is set.
		$this->set_option(CURLOPT_FOLLOWLOCATION, true);

		/**
		 * Apply the startup default parameters, if any
		 */
		if(is_array($custom) && count($custom))
		{
			foreach($custom as $identifier => $data)
			{
				$this->set_option($identifier, $data);
			}
		}

		return true;
	}

	/**
	 * Remove the cookie file created
	 *
	 * @return bool
	 */
	private function delete_cookies()
	{
		if(is_file($this->cookie_file))
		{
			unlink($this->cookie_file);
		}

		return true;
	}

	/**
	 * @param string $url
	 *
	 * @return mixed
	 */
	private function get_url($url = "")
	{
		$this->set_option(CURLOPT_POST, false);
		$this->set_option(CURLOPT_URL, $url);

		return $this->execute();
	}

	/**
	 * @param string $url
	 * @param string $data_string
	 *
	 * @return mixed
	 */
	private function post_url($url = "", $data_string = "")
	{
		$this->set_option(CURLOPT_POST, true);
		$this->set_option(CURLOPT_URL, $url);
		$this->set_option(CURLOPT_POSTFIELDS, $data_string);

		return $this->execute();
	}

	/**
	 * @todo Fix using http_build_query()
	 * @todo parse_str() - Suggested deperecation
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	private function fix_array($data = array())
	{
		$post_data = "";
		$post_data_array = array();
		if(is_array($data) && $data)
		{
			foreach($data as $key => $value)
			{
				$value = urlencode($value); # Added on: 2008-09-24
				$post_data_array[] = "{$key}={$value}";
			}
		}

		if($post_data_array)
		{
			$post_data = implode("&", $post_data_array);
		}

		return $post_data;
	}
}
