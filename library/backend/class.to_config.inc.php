<?php
namespace backend;

/**
 * Send a config array to file that can be included later on.
 */
class to_config
{
	function __construct()
	{
	}

	function to_array($sample = array(), $name = '$config', $depth = 0)
	{
		$string = "";
		$pad = '';
		foreach($sample as $i => $var)
		{
			if(is_int($i))
			{
				$new_name = "{$name}[{$i}]";
			}
			else
			{
				$new_name = "{$name}['{$i}']";
			}

			if(is_array($var))
			{
				$string .= $this->to_array($var, $new_name, $depth + 1);
			}
			else
			{
				#$pad = str_pad($input, $depth, ".", STR_PAD_LEFT);
				$var_treated = '';
				if(is_numeric($var))
				{
					$var_treated = $var;
				}
				else
				{
					$var = str_replace("\\", "\\\\", $var);
					$var = str_replace("'", "\\'", $var);
					$var_treated = "'" . str_replace("\\\"", "\"", $var) . "'";
				}
				$string .= "\n{$pad}\${$new_name} = {$var_treated};";
			}
		}

		return $string;
	} # to_array()
}
