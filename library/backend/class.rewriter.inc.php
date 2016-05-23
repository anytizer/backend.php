<?php
namespace backend;

/**
 * Rewriter for subdomains
 */
class rewriter
{
	private $ini = null; # Parsed INI File

	public function __construct()
	{
	}

	public function process($page = 'index.php')
	{
		$export = array();
		$ini_file = __SUBDOMAIN_BASE__ . '/rewrite.ini';
		if(is_file($ini_file))
		{
			$this->ini = parse_ini_file($ini_file, true);
			#print_r($this->ini);

			foreach($this->ini as $handler => $settings)
			{
				# Validation: pattern, vars, page
				if(!$this->validate_keys($settings))
				{
					\common\stopper::message('rewrite.ini section failed: ' . $handler);
					continue;
				}

				# Try to match a single entry from the sections of ini file
				$data = array();
				if(preg_match($settings['pattern'], $page, $data))
				{
					# $this->$handler($data);
					#print_r($data);
					array_shift($data); # Just to make sure that its ID matches
					#print_r($data);

					# Make the global $vars
					$vars = preg_split('/[^a-z0-9\_]/', $settings['vars']);
					$vars = array_filter($vars);
					#array_unshift($vars, ''); # Just to make sure that its ID matches
					#print_r($vars);


					# Maximum possible number of variables to export
					$max = min(count($data), count($vars));

					# Unset extra flags
					$length = count($data);
					if($max <= $length)
					{
						for($i = $max; $i < $length; ++$i)
						{
							unset($data[$i]);
						}
					}
					#print_r($data);
					# Unset extra flags
					$length = count($vars);
					if($max <= $length)
					{
						for($i = $max; $i < $length; ++$i)
						{
							unset($vars[$i]);
						}
					}
					#print_r($vars);

					$export = array_combine($vars, $data);
					#print_r($export);

					$variable = new \common\variable();

					foreach($export as $key => $value)
					{
						$variable->write('get', $key, $value);
					}

					# Reset the $page name
					$variable->write('get', 'page', $settings['page']);
					$export['page'] = $settings['page'];

					# When there is a match, this is final. Quit others.
					break;
				}
			}
		}

		return $export;
	}


	private function validate_keys($settings = array())
	{
		$success = true;
		$keys = array('pattern', 'vars', 'page', 'force');
		foreach($keys as $key)
		{
			if(!isset($settings[$key]))
			{
				$success = false;
				break;
			}
		}

		return $success;
	}
}
