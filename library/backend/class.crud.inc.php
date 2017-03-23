<?php
namespace backend;

/**
 * Helps to build safe queries in an automated process.
 * Performs INSERT, UPDATE, DELETE operations on the database in the most trusted way.
 */
class crud
	extends \common\mysql
{
	/**
	 * Adds a record into a table.
	 * Add-Controller scripts via ENTITY already checks for a valid protection code.
	 * If add() is not called correctly in manually written scripts, skip protection codes.
	 * $table string Name of the table
	 * $data array associative array of the columns and values
	 * $duplicates array Handles on-duplicate error set
	 * If column names do not match exactly, transate them
	 * To continue with errors on duplicate data, ignore mode
	 */
	public function add($table = "", $data = array(), $duplicates = array(), $translate = false, $ignore_mode = false)
	{
		$columns = array_keys($data);
		$values = array_values($data);
		$values = array_map('trim', $values);
		#\common\stopper::debug($data, true);

		if($translate === true)
		{
			$columns = array_map(array(&$this, 'translate_names'), $columns);
		}
		$columns = implode(', ', array_map(array(&$this, 'tick'), $columns));
		$values = implode(', ', array_map(array(&$this, 'quote'), $values));

		$crud_sql = '#';

		if(!count($duplicates))
		{
			$ignore = ($ignore_mode == false) ? "" : 'IGNORE';
			$crud_sql = "
INSERT {$ignore} INTO `{$table}` (
	{$columns}
) VALUES (
	{$values}
);";
		}
		else
		{
			$duplicates_part = array();
			foreach($duplicates as $column => $value)
			{
				$value = $this->quote($value);
				$duplicates_part[] = "`{$column}` = {$value}";
			}
			$duplicates_part = implode(",\r\n\t", $duplicates_part);
			$crud_sql = "
INSERT INTO `{$table}` (
	{$columns}
) VALUES (
	{$values}
) ON DUPLICATE KEY UPDATE
	{$duplicates_part}
;";
		}
		#\common\stopper::message($crud_sql);

		# If you find that the controller does not reach here,
		# Please check for:
		#   The valid code to allow the system to add (if it is an entity)
		#   Child class name does not collide with system paqrents

		return $this->query($crud_sql) ? $this->insert_id() : false;
	}

	/**
	 * Save the modified records in the database
	 */
	public function update($table = "", $data = array(), $pk = array())
	{
		$crud_sql = '#';

		$pk_conditions = array();
		foreach($pk as $column => $value)
		{
			if(!$column || !$value)
			{
				continue;
			}

			$value = $this->quote($value);
			$pk_conditions[] = "`{$column}` = {$value}";

			# Safety enhancement against hack attempts
			# Immediately unset the list of primary keys
			# if found within the $data variable
			# Supplied primary keys are NOT allowed to modify.
			if(isset($data[$column]))
			{
				unset($data[$column]);
			}
		}
		$pk_conditions = ($pk_conditions) ? implode("\r\n\tAND", $pk_conditions) : null;


		$fields = array();
		foreach($data as $column => $value)
		{
			$value = $this->quote($value);
			$fields[] = "`{$column}` = {$value}";
		}
		$fields = implode(",\r\n\t", $fields);

		$crud_sql = "
UPDATE `{$table}` SET
	{$fields}
WHERE
	{$pk_conditions}
;";
		#\common\stopper::debug($crud_sql, true);
		$this->query($crud_sql);

		return $this->affected_rows();
	}

	/**
	 * Deletes or inactivates a record in a table.
	 */
	public function delete($mode = 'inactivate', $table_name = "", $pk_column = 'id', $pk_value = 0)
	{
		if(!$this->validate(array(
			'mode' => $mode,
			'table_name' => $table_name,
			'pk_column' => $pk_column,
			'pk_value' => $pk_value,
		))
		)
		{
			return false;
		}

		$pk_value += 0;
		$sql = '#';
		switch($mode)
		{
			case 'delete':
				# Permanently remove the record
				# Do not use this except for data sanitization purpose
				$sql = "DELETE FROM `{$table_name}` WHERE `{$pk_column}` = {$pk_value} LIMIT 1;";
				break;
			case 'marked':
				/**
				 * @todo Apply the deleted_on flag in the database, and is_active='D'
				 */
				# delete with delete timestamp / delete marking
				# For logs and sensitive data - hide and mark as deleted.
				# Set is_active to: N, Y, D flags
				# Must have deleted_on column
				$sql = "
UPDATE `{$table_name}` SET
	is_active='D',
	deleted_on = CURRENT_TIMESTAMP()
WHERE
	`{$pk_column}` = {$pk_value}
LIMIT 1;";
				break;
			case 'inactivate':
			default:
				/**
				 * @todo Apply modified_on flags on all other old published application databases
				 */
				# Hide the record. Optionally mark the deleted time
				#$sql="UPDATE `{$table_name}` SET is_active='N' WHERE `{$pk_column}` = {$pk_value} LIMIT 1;";
				$sql = "UPDATE `{$table_name}` SET is_active='N', modified_on = CURRENT_TIMESTAMP() WHERE `{$pk_column}` = {$pk_value} LIMIT 1;";
				break;
		}

		#\common\stopper::debug($sql, false);
		return $this->query($sql);
	}

	/**
	 * Wrap with ticks, particulalry for column names
	 */
	private function tick($name = "")
	{
		return "`{$name}`";
	}

	/**
	 * Wrap a value within two quotation marks.
	 */
	private function quote($value = "")
	{
		# If +, - or tick (`) is found, it can be a valid expression.
		if(preg_match('/[\`|\+\-]/i', $value))
		{
			#return $value;
		}

		/**
		 * Skip these lists from enquoting...
		 * Applications specific
		 */
		$skip = array(
			"f_code('VENDOR', 'CODE')", # Code Generator
		);

		$value = addslashes($value); # Force it, because we have sanitized the user input to the original.

		/**
		 * If the value matches the below expressions, skip enquoting them. Otherwise, forces to quote them.
		 * @todo Preg-Quote the array values.
		 */
		$regex = array(
			# Integers
			# '(\d)+', # Do not do... MUST enquote even if they are integers

			# 'NOW()'
			'NOW\(\)',

			# CURRENT_TIMESTAMP()
			'CURRENT_TIMESTAMP\(\)',

			# CURRENT_DATE()
			'CURRENT_DATE\(\)',

			# CURRENT_TIME()
			'CURRENT_TIME\(\)',

			# YEAR(CURRENT_TIMESTAMP())
			'YEAR\(CURRENT_TIMESTAMP\(\)\)',

			# YEAR(NOW())
			'YEAR\(NOW\(\)\)',

			# UNIX_TIMESTAMP()
			'UNIX_TIMESTAMP\(\)',

			# UNIX_TIMESTAMP(CURRENT_TIMESTAMP())
			'UNIX_TIMESTAMP\(CURRENT_TIMESTAMP\(\)\)',

			# UNIX_TIMESTAMP(DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 20 YEAR));
			'UNIX_TIMESTAMP\(DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ YEAR\)\)',

			# 'UNIX_TIMESTAMP(DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 2 MONTH))'
			'UNIX_TIMESTAMP\(DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ MONTH\)\)',

			# UNIX_TIMESTAMP(DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 7 DAY))
			'UNIX_TIMESTAMP\(DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ DAY\)\)',

			# UNIX_TIMESTAMP('2012-01-01')
			'UNIX_TIMESTAMP\(\'[0-9]{4}\-[0-9]{2}\-[0-9]{2}\'\)',

			# SELECT DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 20 YEAR)
			'DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ YEAR\)',

			#DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 5 MONTH)
			'DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ MONTH\)',

			#DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 5 DAY)
			'DATE_ADD\(CURRENT_TIMESTAMP\(\), INTERVAL (\d)+ DAY\)',

			#DATE_ADD(CURRENT_DATE(), INTERVAL 7 YEAR)
			'DATE_ADD\(CURRENT_DATE\(\), INTERVAL (\d)+ YEAR\)',

			#DATE_ADD(CURRENT_DATE(), INTERVAL 18 MONTH)
			'DATE_ADD\(CURRENT_DATE\(\), INTERVAL (\d)+ MONTH\)',

			# SELECT DATE_ADD(CURRENT_DATE(), INTERVAL 4 DAY)
			'DATE_ADD\(CURRENT_DATE\(\), INTERVAL (\d)+ DAY\)',

			###########################################
			# Application specific (Custom functions) #
			###########################################

			# Records the number of modifications that was made on a particular record
			'modified_counter\+1',
			'[a-z\_]+[\+|\-][\d]+', # column_name+integer, column_name-integer
		);

		$matched = false;
		$data = array();
		foreach($regex as $r => $pattern)
		{
			$data = array();
			#echo("{$pattern}\r\n");
			if(preg_match("/^{$pattern}$/is", $value))
			{
				$matched = true;
				break;
			}
		}
		# $status = ($matched) ? 'Matched' : 'Failed';
		# echo("{$value}: {$status}\r\n");
		if(!$matched)
		{
			$value = "'{$value}'";
		}

		return $value;
	}

	/**
	 * Checks for NON empty values: Must match ALL conditions tried to match.
	 */
	private function validate($conditions = array())
	{
		if(!count($conditions))
		{
			return false;
		}

		$success = true;
		foreach($conditions as $column => $value)
		{
			if(empty($value) || empty($column))
			{
				$success = false;
				break;
			}
		}

		return $success;
	}

	/**
	 * Puts a marker flag in a table, for matching pk
	 */
	private function set_flag($table_name = "", $column_name = "", $value = "", $pk = array())
	{
		# Experiemental only
		return false;
		$value = quote($value);
		$pk_sql = "";
		#$flag_sql = "UPDATE `{$table_name}` SET `{$column_name}` = '{$value}' WHERE `{$column_name}` = 1;";
		$flag_sql = "UPDATE `{$table_name}` SET `{$column_name}`='{$value}', modified_on = CURRENT_TIMESTAMP() WHERE `{$column_name}` = 1;";

		return $flag_sql;
	}


	/**
	 * Modify the column names with a different one!
	 * Lookup table is referenced.
	 */
	private function translate_names($column_name = "")
	{
		$translation = array();
		/**
		 * $translation['company_id'] = 'fk_company_id';
		 * $translation['realtor_id'] = 'fk_realtor_id';
		 * $translation['category_id'] = 'fk_category_id';
		 */

		# Add more, if necessary...

		return !empty($translation[$column_name]) ? $translation[$column_name] : $column_name;
	}

	/**
	 * Sanitize the operator
	 */
	private function sanitize_operator($operator = 'AND')
	{
		switch($operator)
		{
			case 'OR':
			case 'or':
			case '||':
			case '|':
				$operator = 'OR';
				break;
			case 'AND':
			case 'and':
			case '&&':
			case '&':
			default:
				$operator = 'AND';
				break;
		}
		return $operator;
	}

	/**
	 * Compiles a set of conditions
	 */
	public function compile_conditions($conditions = array(), $accept_blank = false, $operator = 'AND', $depth = 1, $exact_match = false)
	{
		$operator = $this->sanitize_operator($operator);

		/**
		 * How to handle blank conditions? May be nothing.
		 */
		if(!count($conditions))
		{
			return 'TRUE'; # Worst case; upper case TRUE
		}

		$conditions_compiled = array();

		$columns = array_keys($conditions);

		$values = array_values($conditions);
		$values = array_map('trim', $values);

		$counter = 0;
		foreach($columns as $i => $column)
		{
			#if($column=="") continue; # No worth calculating the blank column
			if($accept_blank == false && $values[$i] == "")
			{
				continue;
			}
			++$counter;

			if($exact_match !== true)
			{
				# LIKE match
				if(!preg_match('/^[\d]+$/', $column))
				{
					#$conditions_compiled[] = "{$column} LIKE '%{$values[$i]}%'"; # Match: Like

					$values[$i] = addslashes($values[$i]);
					$conditions_compiled[] = "{$column} LIKE '%{$values[$i]}%'"; # Match: Like
				}
				else
				{
					# Full match, conditon is already there, if column is NUMERIC.
					# Trust the values sent
					$conditions_compiled[] = "{$values[$i]}";
				}
			}
			else
			{
				# Exact match
				# Match: Equals
				$values[$i] = addslashes($values[$i]);
				$conditions_compiled[] = "{$column} = '{$values[$i]}'";
			}
		}
		if($counter)
		{
			$spacer = $this->depth_spacer($depth);
			$conditions_compiled = implode("\r\n{$spacer}{$operator} ", $conditions_compiled);
		}
		else
		{
			$conditions_compiled = 'TRUE';
		}

		return $conditions_compiled;
	}

	/**
	 * Get a depth marker
	 */
	private function depth_spacer($depth = 1)
	{
		#echo("Depth: ".$depth);
		$depth = (int)$depth;
		$marker = "";
		$depth_space_original = "\t";
		for($i = 0; $i < $depth; ++$i)
		{
			$marker .= $depth_space_original;
		}

		return $marker;
	}
}

