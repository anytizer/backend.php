<?php
namespace common;

/**
 * Stops execution or debugs a code.
 * Normally, all methods can be called statically.
 * @uses `__TEMP_PATH__`
 * @uses `__SUBDOMAIN_BASE__`
 * @uses `__LIBRARY_PATH__`
 */
class stopper
{
	/**
	 * This constructor is not necessary, as of now
	 */
	public function __construct()
	{
		/**
		 * @todo Discourage the direct access
		 */
		if(!defined('__LIBRARY_PATH__'))
		{
			throw new \Exception("__LIBRARY_PATH__ not defined.");
		}
	}

	/**
	 * Move to a diffferent URL when there is a need.
	 *
	 * @example: \common\stopper::url();
	 */
	public static function url($location = '')
	{
		# URL Sanitization and removal of any NULL characters
		$location = str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $location);
		$location = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%]|i', '', $location);
		$location = preg_replace('/\0+/', '', $location);
		$location = preg_replace('/(\\\\0)+/', '', $location);

		# remove %0d and %0a from location
		$strip = array('%0d', '%0a');
		$found = true;
		while($found)
		{
			$found = false;
			foreach((array)$strip as $val)
			{
				while(strpos($location, $val) !== false)
				{
					$found = true;
					$location = str_replace($val, '', $location);
				}
			}
		}

		# To suppress the errors, try only when the headers were not sent already.
		if(!headers_sent())
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: {$location}", true, 301);

			# @see http://stackoverflow.com/questions/3764075/retry-after-http-response-header-does-it-affect-anything
			# header('Retry-After: 5');
		}

		# Finally stop the execution for the browsers who do not listen well.
		die("<html>
<head>
	<title>Redirecting</title>
	<meta http-equiv=\"refresh\" content=\"0; url={$location}\">
</head>
<body>
	<p>You should be able to redirect to <a href=\"{$location}\">{$location}</a>.</p>
	<script type=\"text/javascript\">window.location='{$location}';</script>
</body>
</html>");
	}

	/**
	 * Show a message about a variable (mixed, array, ingeter, ...
	 * Stop the execution on demand.
	 */
	public static function debug($variable = '', $stop_execution = true)
	{
		#if(defined('__DEBUG__') && __DEBUG__ === true)
		{
			echo("<div class='debug_note'>

=================================================
</div>
<div class='debug_message'>
");
			if(is_object($variable))
			{
				print_r($variable);
			}
			else if(is_array($variable))
			{
				print_r($variable);
			}
			else
			{
				echo($variable);
			}

			echo("
</div>
<div class='debug_message'>
=================================================
</div>
");
		}

		# Halt executing rest of the scripts
		if($stop_execution === true)
		{
			die('...execution stopped here...');
		}

		return false;
	}

	/**
	 * Halts execution of a page.
	 * Alternative to die/exit
	 */
	public static function message($message = '', $halt_html_message = true)
	{
		if($halt_html_message === true)
		{
			# Uses a page decoration with HTML
			$subdomain_error_file = __SUBDOMAIN_BASE__ . '/error-message.php';
			if(is_file($subdomain_error_file))
			{
				# Make sure that we can load the error message template from a specific subdomain.
				require_once($subdomain_error_file);
			}
			else
			{
				if(is_file(__LIBRARY_PATH__ . '/inc/inc.constants.php') && is_file(__LIBRARY_PATH__ . '/error-messages/error-message.php'))
				{
					require_once(__LIBRARY_PATH__ . '/inc/inc.constants.php');
					
					/**
					 * @todo Check here
					 */
					require_once(__LIBRARY_PATH__ . '/error-messages/error-message.php');
				}
				else
				{
					die($message);
				}
			}
		}
		else
		{
			# Through plain error message
			die($message);
		}
		exit(0);
	}

	public static function record($filename = '', $message = '')
	{
		$filename = preg_replace('/[\/|\/]+/', '-', $filename);
		if(!$filename)
		{
			$filename = 'unknown.log';
		}
		$filename = preg_replace('/(\..*?)$/is', '-' . date('YmdHis') . '$1', $filename);
		/**
		 * @todo Warning: file_put_contents(/tmp/mysql-failed.log): failed to open stream: No such file or directory
		 * Appears when system installation was incomplete ie. database config NOT set properly
		 */
		file_put_contents(__TEMP_PATH__ . '/'. $_SERVER['SERVER_NAME'] .'/stopper-' . $filename, "\r\n\r\n" . $message, FILE_BINARY | FILE_APPEND);
	}
}
