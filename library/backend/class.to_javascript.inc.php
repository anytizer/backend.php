<?php
namespace backend;

/**
 * To Javascript: Sends a plain text to javascript written texts.
 *
 * @author Bimal Poudel <bimal@hwbnepal.com>
 * @copyright Bimal Poudel
 */
class to_javascript
{
	private $location;

	public function __construct($write_location = './tmp')
	{
		$this->location = $write_location;
	}

	/**
	 * Convrts an array to document.write() for javascript
	 */
	private function javascript($string = "", $header = true)
	{
		$strings = explode("\n", $string);
		$js = "";

		if($header === true)
		{
			$js .= '<script type="text/javascript">';
		}

		for($i = 0; $i < count($strings); ++$i)
		{
			$string_let = trim($strings[$i]);
			if(!$string_let)
			{
				continue;
			}

			$string_let = str_replace('"', "\\\"", $string_let);
			$js .= "document.write(\"{$string_let}\");\n";
		}

		if($header === true)
		{
			$js .= "\n\r</script>";
		}
		#	echo($js);

		#	\common\stopper::message($strings);
		return $js;
	}

	/**
	 * JS String: Returns a set of all lines as a string
	 */
	public function js_string($lines = array())
	{
	}

	/**
	 * Reads lines of javascripts from external file
	 */
	public function read_external($js)
	{
		$fc = 'Error: js name is not defined or js file does not exist.';
		if($js)
		{
			$fc = file_get_contents("{$this->location}/{$js}.js");
		}

		return $js;
	}

	/**
	 * Dump file contents to an external file
	 */
	public function write_external($conents = "")
	{
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float)$sec + ((float)$usec * 100000));
		$randval = mt_rand();
		$js = md5($randval . microtime());

		$filename = "{$this->location}/{$js}.js";
		$c = $this->javascript($conents, false);
		file_put_contents($filename, $c);

		return $js;
	}

	public function load_external($js = "")
	{
		$contents = "<script type=\"text/javascript\" src=\"{$js}\"></script>";

		return $contents;
	}


	/**
	 * Send a contents of a file into document.write() javascript.
	 * Reads a file.
	 */
	public function send_javascript($file_name = "", $do_mapping = false)
	{
		/*$fc = "<script>alert('js file: {$file_name}' does not exist.');</script>";*/
		#$fc = "alert(JS file: '{$file_name}' does not exist.');";
		$fc = "\r\n//JS file: <strong>{$file_name}</strong> does not exist.\r\n";

		$file_name = "{$this->location}/{$file_name}";
		if(is_file($file_name))
		{
			$fc = file_get_contents($file_name);

			$save_name = basename($file_name); # Optional
		}

		if($do_mapping === true)
		{
			# Add embedding \" for "
			$fc = addslashes($fc);

			#$lines = explode("\n", $fc);
			$lines = explode("\r\n", $fc);
			#\common\stopper::message($lines);

			#$lines = array_map('js_var_line', $lines);
			$lines = array_map(array(&$this, 'js_var_line'), $lines);
		}
		else
		{
			$lines = explode("\r\n", $fc);
		}
		#\common\stopper::message($lines);


		header('Content-type: text/javascript');
		header('Content-Disposition: inline; filename="' . $save_name . '"');
		header('Content-Transfer-Encoding: binary');

		echo(implode("\r\n", $lines));
	}

	/**
	 * Wraps a js line with document.write() looping: to map an array
	 */
	public function js_var_line($line = "")
	{
		# $line = addslashes($line); # Done already. Looping kills the time
		return "document.write(\"{$line}\");";
	}
}
