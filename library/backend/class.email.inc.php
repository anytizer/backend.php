<?php
namespace backend;

# Created on: 2009-11-19 02:02:04 537

/**
 * email Class
 */

/**
 * Operations:
 *    $email->add()
 *        Adds a new record in email
 *    $email->edit()
 *        Modified a record in email
 *    $email->delete()
 *        Removes one of email record
 *    $email->list_entries()
 *        Fetches a list of email records
 *    $email->details()
 *        Fetches the details of email
 */
class email
	extends \abstracts\entity
{
	/**
	 * Optional Constructor: Load on demand only.
	 */
	public function __construct()
	{
		# Parent's default constructor is necessary.
		parent::__construct();

		$this->protection_code = 'b1019a9c3b661c9fe4e77578ad15e193'; # Some random text, valid for the entire life
		$this->table_name = 'query_emails'; # Name of this table/entity name
		$this->pk_column = 'email_id'; # Primary Key's Column Name

		# Pagination helper
		$total_entries_for_pagination = 0; # Number of entries: list_entries()

		/**
		 * Validation fields as used in add/edit forms
		 */
		$this->fields = array(
			# Remove the columns that you do not want to use in the ADD form
			'add' => array(
				'language' => 'EN',
				'email_code' => \common\tools::timestamp(),
				'email_subject' => null,
				'email_html' => null,
				'email_text' => null,
			),

			# Remove the columns that you do not want to use in the EDIT form
			'edit' => array(
				'language' => 'EN',
				'email_code' => \common\tools::timestamp(),
				'email_subject' => null,
				'email_html' => null,
				'email_text' => null,
			),
		);
	}

	/**
	 * Edit/Modify/Update an entry in [ email ]
	 * Post Controller Method Only!
	 *
	 * @param $data Associative array to modify
	 * @param $pk Associative array of primary keys and values
	 * @param $protection_code String Secret Hash Key
	 *
	 * @return Boolean Success or Failure to edit a record
	 */
	public function edit($data = array(), $pk = array(), $protection_code = '', $pk_value = 0)
	{
		# Use $protection_code ... to test the integrity of the posted items. Verifies if the user can edit the entry.
		$code = $this->sanitize($protection_code);
		$pk_value = (int)$pk_value;

		$edit_success = false;
		$test_allow_edit_sql = "
SELECT
	(COUNT(`email_id`) = 1) `allow`
FROM `query_emails` `e`
WHERE
	`email_id` = {$pk_value} # Bring from PK array
	
	# This is optional
	AND MD5(CONCAT(`email_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$permission = $this->row($test_allow_edit_sql);
		if($permission['allow'])
		{
			$crud = new \backend\crud();
			$edit_success = $edit_success = $crud->update(
				$this->table_name,
				$data,
				$pk
			);
		}

		return $edit_success;
	}

	/**
	 * List entries from [ email ]
	 * Column `code` signifies a protection code while deleting/editing a record
	 *
	 * @param $conditions SQL Conditions
	 *
	 * @return Multi-Dimensional array of entries in the list
	 */
	public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
		#list_entries($conditions=array(), $from_index=0, $per_page=50)
	{
		$from_index = (int)$from_index;
		$per_page = (int)$per_page;

		$listing_sql = "
SELECT SQL_CALC_FOUND_ROWS
	e.`email_id`,
	e.`language`,
	e.email_code,
	e.email_subject,
	MD5(CONCAT(`email_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_emails` `e`
WHERE
	e.is_active='Y'
ORDER BY
	e.email_code,
	e.email_subject
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
	 * Details of an entity in [ email ]
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function details($email_id = 0, $code_user = '')
	{
		$code = $this->sanitize($code_user);
		$email_id = (int)$email_id;
		$details_sql = "
SELECT
	e.*,
	MD5(CONCAT(`email_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_emails` `e`
WHERE
	`email_id` = {$email_id}
	# Optionally validate
	# AND MD5(CONCAT(`email_id`, '{$this->protection_code}')) = '{$code_user}'
;";
		$details = $this->row($details_sql);

		return $details;
	}


	/**
	 * For compatibility only
	 */
	public function get_details($subdomain_id = 0, $protection_code = '')
	{
		return null;
	}


	/**
	 * Allow to operate on a particular record, with its protection code
	 */
	protected function allow_protected_action($email_id = 0, $protection_code = '')
	{
		# Action is: edit:update / delete:inactivate
		$email_id = (int)$email_id;
		$protection_code = $this->sanitize($protection_code);
		$test_allow_action_sql = "
SELECT
	(COUNT(`email_id`) = 1) `allow`
FROM `query_emails` `e`
WHERE
	`email_id` = {$email_id}
	
	# This is NOT optional: Must Pass
	AND MD5(CONCAT(`email_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
		$permission = $this->row($test_allow_action_sql);

		return $permission['allow'];
	}
}

