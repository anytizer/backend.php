<?php
namespace \subdomain;

# Created on: 2009-11-11 20:04:26 653

/**
 * menus Class
 */

/**
 * Operations:
 *    $menus->add()
 *        Adds a new record in menus
 *    $menus->edit()
 *        Modified a record in menus
 *    $menus->delete()
 *        Removes one of menus record
 *    $menus->list_entries()
 *        Fetches a list of menus records
 *    $menus->details()
 *        Fetches the details of menus
 */
class menus
	extends \common\mysql
{
	/**
	 * Set Private, Protected or Public Members
	 */
	private $protection_code = 'e005b104b328680b5901b0d5ce631410'; # Some random text, valid for the entire life

	/**
	 * Optional Constructor: Load on demand only.
	 */
	/*
	public function __construct()
	{
		# Parent's default constructor is necessary.
		parent::__construct();

		$this->protection_code = 'e005b104b328680b5901b0d5ce631410'; # Some random text, valid for the entire life
	}
	*/

	/**
	 * Add a new entry into [ menus ]
	 *
	 * @param array Associative array of columns in [ menus ]
	 *
	 * @return Integer (menus ID) as entered into the database.
	 */
	public function add($data = array())
	{
		$crud = new \backend\crud();
		$menus_id = $crud->add('query_menus', $data, array(), false, false);

		return $menus_id;
	}

	/**
	 * Edit/Modify/Update an entry in [ menus ]
	 * Post Controller Method Only!
	 *
	 * @param $data Associative array to modify
	 * @param $pk Associative array of primary keys and values
	 * @param $code String Secret Hash Key
	 *
	 * @return Boolean Success or Failure to edit a record
	 */
	public function edit($data = array(), $pk = array(), $code = "", $menu_id = 0)
	{
		$menu_id = (int)$menu_id;
		# Verify if the user can edit the entry.
		# Use $code ... to test the integrity of the posted items
		$code = $this->sanitize($code);

		$edit_success = false;
		$test_allow_edit_sql = "
SELECT
	(COUNT(`menu_id`) > 0) `allow`
FROM `query_menus` `e`
WHERE
	`menu_id` = '{$menu_id}' AND # This line can be optional
	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) = '{$code}'
;";
		#\common\stopper::message($test_allow_edit_sql);
		$permission = $this->row($test_allow_edit_sql);
		if($permission['allow'])
		{
			$crud = new \backend\crud();
			$edit_success = $crud->update('query_menus', $data, $pk);
		}

		return $edit_success;
	}

	/**
	 * Delete a record from [ menus ]
	 * 
	 * @param int $pk_value Integer: menus_id to delete
	 * @param string $protection_code String Secret Hash Key
	 * @return bool
	 */
	public function delete($pk_value = 0, $protection_code = "")
	{
		$protection_code = $this->sanitize($protection_code);

		$crud = new \backend\crud();
		$delete_success = $crud->delete(
			$mode = 'inactivate',
			$table_name = 'query_menus',
			$pk_column = 'menu_id',
			$pk_value
		);

		return $delete_success;
	}

	/**
	 * List entries from [ menus ]
	 * Column `code` signifies a protection code while deleting/editing a record
	 *
	 * @param $conditions SQL Conditions
	 *
	 * @return Multi-Dimensional array of entries in the list
	 */
	public function list_entries($conditions = array())
	{
		$listing_sql = "
SELECT
	e.*,
	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_menus` `e`
WHERE
	e.is_active='Y'
ORDER BY
	menu_context,
	menu_text
;";
		$this->query($listing_sql);
		$entries = $this->to_array();

		return $entries;
	}

	/**
	 * Details of an entity in [ menus ]
	 *
	 * @param $pk integer Primary Key's value of an entity
	 *
	 * @return $details Associative Array of Detailed records of an entity
	 */
	public function details($pk = 0)
	{
		$pk = (int)$pk;
		$details_sql = "
SELECT
	e.*,
	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_menus` `e`
WHERE
	`menu_id` = {$pk}
	# AND MD5(CONCAT(`menu_id`, '{$this->protection_code}')) = 'some user input code'
;";
		$details = $this->row($details_sql);

		return $details;
	}

	/**
	 * List of menu contexts used so far
	 */
	public function used_contexts()
	{
		$contexts_sql = "
SELECT
	menu_context
FROM query_menus
WHERE
	menu_link!="" # Kicks off accidentally recorded contexts
GROUP BY
	menu_context
ORDER BY
	menu_context
;";
		$this->query($contexts_sql);
		$contexts = $this->to_array();

		return $contexts;
	}

	/**
	 * List of menu contexts used so far
	 */
	public function used_texts_under_context($context = "")
	{
		$context = \common\tools::safe_sql_word($context);
		$contexts_sql = "
SELECT
	menu_text
FROM query_menus
WHERE
	menu_context='{$context}'
	AND menu_link!=""
	AND is_active='Y'
ORDER BY
	menu_text
;";
		$this->query($contexts_sql);
		$contexts = $this->to_array();

		return $contexts;
	}

	/**
	 * List menus under a context, for sorting them
	 */
	function list_menus_for_sorting($menu_context = "")
	{
		$menu_context = \common\tools::safe_sql_word($menu_context);
		$menus_sql = "
SELECT
	e.*
FROM `query_menus` `e`
WHERE
	e.is_active='Y'
	AND e.menu_context='{$menu_context}'
ORDER BY
	e.sink_weight ASC
;";
		$this->query($menus_sql);
		$menus = $this->to_array();

		return $menus;
	}

	/**
	 * Sanitize code against hacks
	 */
	private function sanitize($string = "")
	{
		return \common\tools::sanitize_name($string);
	}
}