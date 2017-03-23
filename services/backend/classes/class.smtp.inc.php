<?php
namespace \subdomain;


# Created on: 2010-10-06 12:53:18 781

/**
 * smtp Class
 */

/**
 * Operations:
 *    $smtp->add()
 *        Adds a new record in smtp
 *    $smtp->edit()
 *        Modified a record in smtp
 *    $smtp->delete()
 *        Removes one of smtp record
 *    $smtp->list_entries()
 *        Fetches a list of smtp records
 *    $smtp->details()
 *        Fetches the details of smtp
 */
class smtp
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
		$this->protection_code = '7d9ecfd263ef29c4ca6421a2d5dcfe06'; # Some random text, valid for the entire life
		$this->table_name = 'query_emails_smtp'; # Name of this table/entity name
		$this->pk_column = 'smtp_id'; # Primary Key's Column Name

		/**
		 * Validation fields as used in add/edit forms
		 */
		$this->fields = array(
			# Remove the columns that you do not want to use in the ADD form
			'add' => array(
				'smtp_identifier' => \common\tools::timestamp(),
				'smtp_host' => null,
				'smtp_port' => null,
				'do_authenticate' => null,
				'smtp_username' => null,
				'smtp_password' => null,
				'from_name' => null,
				'from_email' => null,
				'replyto_name' => null,
				'replyto_email' => null,
				'smtp_comments' => null,

				'subdomain_id' => 0,
			),

			# Remove the columns that you do not want to use in the EDIT form
			'edit' => array(
				'smtp_identifier' => null,
				'smtp_host' => null,
				'smtp_port' => null,
				'do_authenticate' => null,
				'smtp_username' => null,
				'smtp_password' => null,
				'from_name' => null,
				'from_email' => null,
				'replyto_name' => null,
				'replyto_email' => null,
				'smtp_comments' => null,

				'subdomain_id' => 0,
			),
		);
	}

	/**
	 * List entries from [ smtp ]
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
	# must include smtp_id
	e.*,
	
	MD5(CONCAT(`smtp_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_emails_smtp` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
LIMIT {$from_index}, {$per_page}
;";

# Extra
#	e.user_id = {$variable->session('user_id', 'integer', 0)}
#	AND e.is_active = 'Y'

		/*
				$listing_sql="
		SELECT SQL_CALC_FOUND_ROWS
			`smtp_id`, # Do not remove this

			# Modify these columns
			e.*,

			MD5(CONCAT(`smtp_id`, '{$this->protection_code}')) `code` # Protection Code
		FROM `query_emails_smtp` `e`
		WHERE
			e.is_active='Y'
		LIMIT {$from_index}, {$per_page}
		;";*/
		$this->query($listing_sql);
		$entries = $this->to_array();

		# Pagination helper: Set the number of entries
		$counter_sql = "SELECT FOUND_ROWS() total;"; # Uses SQL_CALC_FOUND_ROWS from above query. So, run it immediately.
		$totals = $this->row($counter_sql);
		$this->total_entries_for_pagination = $totals['total'];

		return $entries;
	}

	/**
	 * Details of an entity in [ smtp ] for management activities
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function details($smtp_id = 0)
	{
		$smtp_id = (int)$smtp_id;
		$details_sql = "
SELECT
	e.*,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`smtp_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_emails_smtp` `e`
WHERE
	`smtp_id` = {$smtp_id}
;";
		$details = $this->row($details_sql);

		return $details;
	}

	/**
	 * Details of an entity in [ smtp ] for public display.
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function get_details($smtp_id = 0, $protection_code = "")
	{
		$protection_code = $this->sanitize($protection_code);
		$smtp_id = (int)$smtp_id;
		$details_sql = "
SELECT
	e.*,

	MD5(CONCAT(`smtp_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_emails_smtp` `e`
WHERE
	`smtp_id` = {$smtp_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`smtp_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$details = $this->row($details_sql);

		return $details;
	}
}