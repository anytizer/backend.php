<?php
namespace common;

/**
 * Secured Form Handling - Anti Hack Attempt:
 * Trap if user has modified the FORM's elements, names or sequences.
 *
 * @package Common
 */
class form
{
	/**
	 * A place holder for names of HTML FORM elements.
	 */
	private $elements;

	/**
	 * Begin with empty keys
	 */
	public function __construct()
	{
		$this->elements = array();
	}

	/**
	 * On trial
	 *
	 * @param array $elements_associative
	 */
	public function elements($elements_associative = array())
	{
		#$keys = array_keys($elements_associative);
		$keys = array_values($elements_associative);
		$keys = array_map(array(&$this, 'element'), $keys);
	}

	/**
	 * &* Draw an element. Sanitizes and stores for server side ke generation.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	private function element($name = '')
	{
		$name = $this->sanitize($name);
		$this->elements[$name] = mt_rand(1000, 9999); # md5(mt_rand(1000, 9999).microtime());
		return $name;
	}

	/**
	 * Make a key at server side.
	 *
	 * @return bool|string
	 */
	public function generate_key()
	{
		if(empty($this->elements))
		{
			return false;
		}
		$keys = array_keys($this->elements);
		$hash = $this->hash($keys);

		return $hash;
	}

	/**
	 * Match, if an HTML FORM is well secured.
	 * Confirms, the client returned all KEYs without modification. (client did not add the keys / client did not remove the keys)
	 *
	 * @param array $elements_associative POST[FORM-NAME][KEYS[]]
	 *
	 * @return bool
	 */
	public function check_security($elements_associative = array())
	{
		$keys = array_keys($elements_associative);
		$keys = array_map(array(&$this, 'sanitize'), $keys);
		$hash = $this->hash($keys);

		$matched = $hash != '' && $hash == $this->generate_key();
		return $matched;
	}

	/**
	 * @todo Use dynamic strings to generate hash
	 *
	 * @param array $keys
	 *
	 * @return string
	 */
	private function hash($keys = array())
	{
		rsort($keys); # A way to obfuscate
		$string = md5('HaSHKeY' . implode('', $keys) . 'RaND0M');

		return $string;
	}

	/**
	 * Allow alphabets only
	 */
	private function sanitize($name = '')
	{
		return \common\tools::alphabetic($name);
	}
}
