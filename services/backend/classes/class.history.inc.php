<?php
namespace subdomain;

# Created on: 2010-12-27 11:38:12 391

/**
 * history Class
 */

/**
 * Operations:
 *    $history->add()
 *        Adds a new record in history
 *    $history->edit()
 *        Modified a record in history
 *    $history->delete()
 *        Removes one of history record
 *    $history->list_entries()
 *        Fetches a list of history records
 *    $history->details()
 *        Fetches the details of history
 */
class history
	extends \abstracts\entity
{
	/**
	 * Optional Constructor: Load on demand only.
	 */
	public function __construct()
	{
		# Parent's default constructor is necessary.
		parent::__construct();

		/**
		 * Set Private, Protected or Public Members
		 */
		$this->protection_code = 'dfdc00e744ca900e598707d0b1ab07fb'; # Some random text, valid for the entire life
		$this->table_name = 'query_development_history'; # Name of this table/entity name
		$this->pk_column = 'history_id'; # Primary Key's Column Name

		/**
		 * Validation fields as used in add/edit forms
		 */
		$this->fields = array(
			# Remove the columns that you do not want to use in the ADD form
			'add' => array(
				'history_title' => null,
				'history_text' => null,
			),

			# Remove the columns that you do not want to use in the EDIT form
			'edit' => array(
				'history_title' => null,
				'history_text' => null,
			),
		);
	}

	/**
	 * List entries from [ history ]
	 * Column `code` signifies a protection code while deleting/editing a record
	 *
	 * @param $conditions SQL Conditions
	 *
	 * @return Multi-Dimensional array of entries in the list
	 */
	public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
	{
		$crud = new \backend\crud();

		$conditions_compiled_AND = $crud->compile_conditions(
			$condition->get_condition('AND'),
			false, 'AND', 1
		);
		$conditions_compiled_OR = $crud->compile_conditions(
			$condition->get_condition('OR'),
			false, 'OR', 2
		);

		$from_index = (int)$from_index;
		$per_page = (int)$per_page;
		$variable = new \common\variable(); # It may be necessary to read list out data of a user

		$listing_sql = "
SELECT SQL_CALC_FOUND_ROWS
	e.`history_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`subdomain_id`,
	e.`added_on`,
	e.`history_title`,
	
	MD5(CONCAT(`history_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_development_history` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	subdomain_id,
	`history_id` DESC
LIMIT {$from_index}, {$per_page}
;";

		$this->query($listing_sql);
		$entries = $this->to_array();

		# Pagination helper: Set the number of entries
		$counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
		$totals = $this->row($counter_sql);
		$this->total_entries_for_pagination = $totals['total'];

		return $entries;
	}

	/**
	 * Details of an entity in [ history ] for management activities
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function details($history_id = 0)
	{
		$history_id = (int)$history_id;
		$details_sql = "
SELECT
	e.`history_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`history_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_development_history` `e`
WHERE
	`history_id` = {$history_id}
;";
		$details = $this->row($details_sql);

		return $details;
	}

	/**
	 * Details of an entity in [ history ] for public display.
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function get_details($history_id = 0, $protection_code = '')
	{
		$protection_code = $this->sanitize($protection_code);
		$history_id = (int)$history_id;
		$details_sql = "
SELECT
	`history_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`history_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_development_history` `e`
WHERE
	`history_id` = {$history_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`history_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$details = $this->row($details_sql);

		return $details;
	}
}