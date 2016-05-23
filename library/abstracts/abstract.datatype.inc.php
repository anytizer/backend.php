<?php
namespace abstracts;

/**
 * An abstract form of data holding box - to enhance the security, that the object cannot contain unnecessary members.
 * Also, helps to return multiple parameters from a function output.
 *
 * @package Interfaces
 */
abstract class datatype
{
	private $data; # Set of values
	private $indices; # Set of indices


	/**
	 * The constructor should give a set of indices to be used in its life time.
	 */
	protected function __construct($array_of_indices = array())
	{
		if (!is_array($array_of_indices)) {
			\common\stopper::message('Give a list of indices only.');
		}

		$this->indices = array();
		foreach ($array_of_indices as $key => $name) {
			# Only alphabets and an underscore are allowed as an index name
			# Other indices are simply discarded
			if (preg_match('/^[a-z\_]+$/is', $name)) {
				$this->indices[] = $name;
				$this->data[$name] = null; # Set the empty values, and initiate the data/index
			}
		}
	}


	/**
	 * Checks whether an index is valid
	 *
	 * @param $index string Index Key to check for validity
	 */
	private function is_index_valid($index = '')
	{
		$success = false;
		if (!is_array($this->indices)) {
			\common\stopper::message('Indices error.');
		}

		if (!in_array($index, $this->indices)) {
			# Ouch, please do not avoid the rules.
			#\common\stopper::debug($this, true);
			\common\stopper::message("
Data Type Error: Invalid index <strong>{$index}</strong>.<br />
Valid list is:<br>
&nbsp; &nbsp; [" . implode(']<br>&nbsp; &nbsp; [', $this->indices) . "]
"
			);
		} else {
			$success = true;
		}

		return $success;
	}


	/**
	 * Reads value of an index
	 *
	 * @param $index string Index Key to read
	 *
	 * @return bool
	 */
	public function __get($index = '')
	{
		$value = $this->is_index_valid($index) ? $this->data[$index] : false;

		return $value;
	}


	/**
	 * Writes a value for an index
	 *
	 * @param string $index Index Key to write
	 * @param string $value Value to write
	 *
	 * @return bool
	 */
	public function __set($index = '', $value = '')
	{
		$success = false;
		if ($this->is_index_valid($index)) {
			$this->data[$index] = $value;
			$success = true;
		}

		return $success;
	}


	/**
	 * Determines the validity of an index
	 *
	 * @param string $index Index Key to check
	 *
	 * @return bool
	 */
	public function __isset($index = '')
	{
		return $this->is_index_valid($index);
	}


	/**
	 * Optionally reset an index.
	 *
	 * @param $index string Index Key to unset
	 */
	public function __unset($index = '')
	{
		$success = false;
		if ($this->is_index_valid($index)) {
			unset($this->data[$index]);
			$success = true;
		}

		return $success;
	}

	/**
	 * Explain oneself
	 */
	public function __toString()
	{
		return print_r($this, true);
	}
}
