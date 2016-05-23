<?php
namespace common;

/**
 * The Tab-Separated-Values parser
 * Useful specially while importing the excel data by copy/paste method.
 *
 * @package Common
 */
class parser
	extends array_operation
{
	public $inclulde_field_name = false;

	public $lines = array();
	public $data = array();
	public $assigns = array();
	public $columns = array();

	public function parse(&$post_field_name = '')
	{
		#\common\stopper::message("Data: ".$post_field_name);
		$this->lines = explode("\n", $post_field_name); # POST['textfield']
		#$this->lines = $this->operate('trim', $this->lines); # Optional: We will do this for each cell entry
		$this->data = $this->operate('explode_tabs', $this->lines);

		# Optional treatment: Odd-man-out, for the last entry, Optional
		$this->remove_last();

		# Optional ttreatment: Save memeory
		$this->lines = null;
	}

	public function treat_cells($treat = array('trim', 'addslashes', 'wrap_quotes_single'))
	{
		foreach($this->data as $i => $v)
		{
			$this->data[$i] = $this->operate('trim', $this->data[$i]);
			$this->data[$i] = $this->operate('addslashes', $this->data[$i]); # Optional and situational
			$this->data[$i] = $this->operate('wrap_quotes_single', $this->data[$i]);
			#$this->data[$i] = $this->operate('wrap_ticks', $this->data[$i]);
		}
	}

	/**
	 * Remove the last line when it does not match the criteria as in other lines
	 * This can happen normally, while copy/pasting from the excel data
	 */
	public function remove_last()
	{
		#\common\stopper::debug($this->data[count($this->data)-1], false);
		if(count($this->data[count($this->data) - 1]) == 1)
		{
			unset($this->data[count($this->data) - 1]);

			return true; # Last line was removed
		}

		return false; # # Last line was NOT removed. No problem at all
	}

	/**
	 * IF the TSV contained valid column names, use the first row as the column name.
	 */
	public function first_row_is_column($has_column = false)
	{
		if($has_column === true)
		{
			$this->columns = $this->data[0];
			unset($this->data[0]);

			# Remove the attributes, if was assigned.
			$this->columns = $this->operate('remove_quotes', $this->columns);
			$this->columns = $this->operate('wrap_ticks', $this->columns);

			# Optional, single line solution
			# $this->columns = $this->operate('quotes_to_ticks', $this->columns);
		}
	}

	/**
	 * For SQL building, assign the columns and values.
	 * SET method: a=x, b=y
	 * VALUES mehtod: (a, b) VALUES (x, y)
	 */
	public function assign_columns_data($for_update = false)
	{
		if($for_update == false)
		{
			# a=x, b=y
			foreach($this->data as $i => $v)
			{
				# In array operation
				$this->assigns[$i] = $this->assign_columns($this->columns, $this->data[$i]);
			}
		}
		else
		{
			# (a, b) VALUES (x, y)
			foreach($this->data as $i => $v)
			{
				$this->assigns[$i] = $this->assign_columns($this->columns, $this->data[$i]);
			}
		}

		#$this->assigns[$i] = implode(',', $this->assigns[$i]); # Optional line

		# Values pair
	}

	/**
	 * Set the column names manually
	 */
	public function assign_column_names($array_names = array())
	{
		$this->columns = $array_names;

		# Do as in first_row_is_column() method.
		$this->columns = $this->operate('remove_quotes', $this->columns);
		$this->columns = $this->operate('wrap_ticks', $this->columns);
	}
}
