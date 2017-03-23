<?php
namespace backend;

/**
 * Helpful in building our framework based mysql tables

 */
class mysql_table
{
	private $prefix = ""; # prefix in table name
	private $primary_prefix = ""; # prefix in column names
	private $comments = ""; # table comments

	public function __construct($prefix = "", $comments = "")
	{
		$this->prefix = preg_replace('/[^a-z]+/is', "", $prefix);
		$this->comments = preg_replace('/[^a-z0-9\.\-\_\ ]+/is', "", $comments);
	}

	/**
	 * Generate the MySQL valid SQL to create a table with prefix.
	 */
	public function create($table = "", $columns = array())
	{
		$this->primary_prefix = $this->_prefix_key($table);

		$full_columns = implode(",\r\n ", array_map(array(&$this, '_full_column'), $columns));

		$create_sql = "
# DROP TABLE IF EXISTS `{$this->prefix}_{$table}`;
CREATE TABLE `{$this->prefix}_{$table}` (
 `{$this->primary_prefix}_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Runner ID',
 `subdomain_id` INT(10) UNSIGNED DEFAULT '0' NOT NULL COMMENT 'Subdomain ID',

 # The administrative columns
 `added_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on (first time)',
 `fixed_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
 `modified_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modified on',
 `modified_counter` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'How many times is this record modified?',
 `sink_weight` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
 `is_active` ENUM('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active record?',
 `is_approved` ENUM('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Did we approve this record?',

 # User defined columns
 {$full_columns},

 # Primary key
 PRIMARY KEY (`{$this->primary_prefix}_id`)
) COMMENT '{$this->comments}';";

		return $create_sql;
	}

	/**
	 * Make a full column listing. Column name can often contain coumn comments.
	 */
	private function _full_column($column_name_full = "")
	{
		# Make the column name from readable string
		$column_name = strtolower(preg_replace('/[\ ]+/is', '_', $column_name_full));
		$column_name = preg_replace('/[^a-z0-9\_].*?$/is', "", $column_name); # Remove the breakers: \:|\|

		# If the column name already contains an underscore, do not prefix.
		$column_prefix = (!preg_match('/\_/is', $column_name)) ? $this->primary_prefix . '_' : "";

		# Readable comments: Check if there is a comment requested in the field
		# When not found, use the coulumn name itself as the comment text
		$comment = trim(preg_replace('/^[a-z0-9\_\ ]+\:/is', "", $column_name_full));
		$comment = (($comment != $column_name) ? $comment : "");
		if($comment == "")
		{
			$comment = implode(' ', array_map('ucfirst', array_filter(explode('_', $column_name))));
		}

		$full_column = "`{$column_prefix}{$column_name}` varchar(255) NOT NULL DEFAULT "" COMMENT '{$comment}'";

		return $full_column;
	}

	/**
	 * Remove the plural forms - Produce the singular form of a word
	 */
	private function _prefix_key($column_name = "")
	{
		$replaces = array(
			"/ies$/is" => "y",
			"/oes$/is" => "o", # mangoes|mango
			"/ee([a-z])$/is" => "oo$1", # :-( degrees|degroo, feet|foot
			"/s$/is" => "",
			"/sses$/is" => "ss", # businesses|business
		);
		$column_name = preg_replace(array_keys($replaces), array_values($replaces), $column_name);

		return $column_name;
	}

	/**
	 * Return a singular form of a word
	 *
	 * @see CRUDer column name function
	 */
	public function singular($word = "")
	{
		return $this->_prefix_key($word);
	}
}

