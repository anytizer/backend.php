<?php
namespace backend;

/**
 * Installed system module
 */
class system_module
	extends \common\mysql
{
	private $subdomain_name = '';

	/*	public function __construct()
		{
		}
	*/
	/**
	 * Check, if a module is valid or not
	 */
	public function is_valid()
	{
		$variable = new \common\variable();
		$pages = explode('/', $variable->get('page', 'string', ''));
		if(!$pages)
		{
			# Not a chance of being a module:
			return false;
		}
		$module = preg_replace('/[^a-z0-9]/is', '', $pages[0]);
		$modules_sql = "SELECT * FROM query_subdomains WHERE subdomain_name = '{$module}' AND is_active='Y';";
		$records = $this->row($modules_sql);
		if(!$records)
		{
			# Invalid or uninstalled module
			return false;
		}
		else
		{
			$this->subdomain_name = $module;

			#\common\stopper::debug($records, false);
			return true;
		}
	}

	/**
	 * Uniquely identifying name of this module
	 */
	public function name()
	{
		return $this->subdomain_name;
	}

	/**
	 * Based on the file name, send the proper header
	 */
	public function send_header($page = 'test.png')
	{
		$is_dynamic = true; # Continue more, even after this?...
		$extensions = explode('.', $page);
		#\common\stopper::debug($extensions, false);
		$extension = $extensions[count($extensions) - 1];
		#\common\stopper::message("Extension: <strong>{$extension}</strong>");
		switch($extension)
		{
			case 'php':
			case 'htm':
			case 'html':
				header('Content-Type: text/html');
				break;
			case 'js':
				$is_dynamic = false;
				header('Content-Type: text/javascript');
				break;
			case 'css':
				$is_dynamic = false;
				header('Content-Type: text/css');
				break;
			case 'xml':
				header('Content-Type: text/xml');
				break;
			case 'gif':
				$is_dynamic = false;
				header('Content-Type: image/gif');
				break;
			case 'jpg':
				$is_dynamic = false;
				header('Content-Type: image/jpgeg');
				break;
			case 'png':
				$is_dynamic = false;
				header('Content-Type: image/png');
				break;
			default:
				header("Content-Transfer-Encoding: binary");
			#header('Content-Type');
			# header('Content-type: application/force-download');
		}

		# js css pdf gif jpg png doc rtf txt xls mp3 zip gz tar tgz

		return $is_dynamic;
	}
}

