<?php
namespace subdomain;

# Created on: 2010-06-11 02:19:25 152

/**
 * tables Class
 */

/**
 * Operations:
 *    $tables->add()
 *        Adds a new record in tables
 *    $tables->edit()
 *        Modified a record in tables
 *    $tables->delete()
 *        Removes one of tables record
 *    $tables->list_entries()
 *        Fetches a list of tables records
 *    $tables->details()
 *        Fetches the details of tables
 */
class tables
    extends abstracts\entity
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
        $this->protection_code = '50e3e236a3694777fd0280964753859d'; # Some random text, valid for the entire life
        $this->table_name = 'query_tables'; # Name of this table/entity name
        $this->pk_column = 'table_id'; # Primary Key's Column Name
    }


    /**
     * List entries from [ tables ]
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
	`table_id`, # Do not remove this
	
	# Modify these columns
	e.*,
	
	MD5(CONCAT(`table_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_tables` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	e.table_name
LIMIT {$from_index}, {$per_page}
;";

# Extra
#	e.user_id = {$variable->session('user_id', 'integer', 0)}
#	AND e.is_active = 'Y'

        /*
                $listing_sql="
        SELECT SQL_CALC_FOUND_ROWS
            `table_id`, # Do not remove this

            # Modify these columns
            e.*,

            MD5(CONCAT(`table_id`, '{$this->protection_code}')) `code` # Protection Code
        FROM `query_tables` `e`
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
     * Details of an entity in [ tables ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($table_id = 0)
    {
        $table_id = (int)$table_id;
        $details_sql = "
SELECT
	`table_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`table_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_tables` `e`
WHERE
	`table_id` = {$table_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ tables ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($table_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $table_id = (int)$table_id;
        $details_sql = "
SELECT
	`table_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`table_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_tables` `e`
WHERE
	`table_id` = {$table_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`table_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Sanitize code against hacks
     */
    protected function sanitize($string = "")
    {
        return \common\tools::sanitize_name($string);
    }

    /**
     * Reads out the total number of entries
     * Pagination helper
     */
    public function total_entries()
    {
        return $this->total_entries_for_pagination;
    }

    /**
     * Allow to operate on a particular record, with its protection code
     */
    protected function allow_protected_action($table_id = 0, $protection_code = "")
    {
        # Action is: edit:update / delete:inactivate
        $table_id = (int)$table_id;
        $protection_code = $this->sanitize($protection_code);
        $test_allow_action_sql = "
SELECT
	(COUNT(`table_id`) = 1) `allow`
FROM `query_tables` `e`
WHERE
	`table_id` = {$table_id}
	
	# This is NOT optional: Must Pass
	AND MD5(CONCAT(`table_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $permission = $this->row($test_allow_action_sql);

        return $permission['allow'];
    }

    /**
     * Matches the user-returned protection code with its valid one
     */
    protected function is_valid_code($protection_code = "")
    {
        $real_code = $this->code();
        $is_valid = (($real_code == $protection_code) && ($protection_code != ""));

        return $is_valid;
    }
}
