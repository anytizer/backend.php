<?php
namespace subdomain;



/**
 * defines Class
 */

/**
 * Operations:
 *    $defines->add()
 *        Adds a new record in defines
 *    $defines->edit()
 *        Modified a record in defines
 *    $defines->delete()
 *        Removes one of defines record
 *    $defines->list_entries()
 *        Fetches a list of defines records
 *    $defines->details()
 *        Fetches the details of defines
 */
class defines
    extends \abstracts\entity
{
    /**
     * Optional Constructor: Load on demand only.
     */
    public function __construct()
    {
        # Parent's default constructor is necessary.
        parent::__construct();

        $this->protection_code = 'e1b8253b87cfd0191a01f607b1a4598b'; # Some random text, valid for the entire life
        $this->table_name = 'query_defines'; # Name of this table/entity name
        $this->pk_column = 'define_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'subdomain_id' => 0,
                'define_context' => 'config',
                'define_name' => null,
                'define_value' => null,
                'define_sample' => null,
                'define_handler' => null,
                'define_comments' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'subdomain_id' => 0,
                'define_context' => 'config',
                'define_name' => null,
                'define_value' => null,
                'define_sample' => null,
                'define_handler' => null,
                'define_comments' => null,
            ),
        );
    }

    /**
     * Edit/Modify/Update an entry in [ defines ]
     * Post Controller Method Only!
     *
     * @param $data Associative array to modify
     * @param $pk Associative array of primary keys and values
     * @param $protection_code String Secret Hash Key
     *
     * @return Boolean Success or Failure to edit a record
     */
    public function edit($data = array(), $pk = array(), $protection_code = "", $define_id = 0)
    {
        # Use $protection_code ... to test the integrity of the posted items.
        # First, Verifies if the user can edit the entry with the supplied protection code.
        $protection_code = $this->sanitize($protection_code);
        $define_id = (int)$define_id;

        $edit_success = false;
        if ($this->allow_protected_action($define_id, $protection_code)) {
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
     * Sanitize code against hacks
     */
    protected function sanitize($string = "")
    {
        return \common\tools::sanitize_name($string);
    }

    /**
     * Allow to operate on a particular record, with its own protection code
     *
     * @return boolan Success or failure status
     */
    protected function allow_protected_action($define_id = 0, $protection_code = "")
    {
        # Action is: edit:update / delete:inactivate
        $define_id = (int)$define_id;
        $protection_code = $this->sanitize($protection_code);
        $test_allow_action_sql = "
SELECT
	(COUNT(`define_id`) = 1) `allow`
FROM `query_defines` `e`
WHERE
	`define_id` = {$define_id}
	
	# This is NOT optional: Must Pass
	AND MD5(CONCAT(`define_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $permission = $this->row($test_allow_action_sql);
        if (!isset($permission['allow'])) {
            $permission = array(
                'allow' => false,
            );
        }

        return $permission['allow'];
    }

    /**
     * List entries from [ defines ]
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
	`define_id`, # Do not remove this
	
	# Modify these columns
	e.*,
	
	MD5(CONCAT(`define_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_defines` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	define_context,
	define_name
LIMIT {$from_index}, {$per_page}
;";

# Extra
#	e.user_id = {$variable->session('user_id', 'integer', 0)}
#	AND e.is_active = 'Y'

        /*
                $listing_sql="
        SELECT SQL_CALC_FOUND_ROWS
            `define_id`, # Do not remove this

            # Modify these columns
            e.*,

            MD5(CONCAT(`define_id`, '{$this->protection_code}')) `code` # Protection Code
        FROM `query_defines` `e`
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
     * Details of an entity in [ defines ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($define_id = 0)
    {
        $define_id = (int)$define_id;
        $details_sql = "
SELECT
	`define_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`define_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_defines` `e`
WHERE
	`define_id` = {$define_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ defines ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($define_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $define_id = (int)$define_id;
        $details_sql = "
SELECT
	`define_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`define_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_defines` `e`
WHERE
	`define_id` = {$define_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`define_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
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
     * Matches the user-returned protection code with its valid one
     */
    protected function is_valid_code($protection_code = "")
    {
        $real_code = $this->code();
        $is_valid = (($real_code == $protection_code) && ($protection_code != ""));

        return $is_valid;
    }

    /**
     * Returns the encrypted protection code in a dynamic manner
     * @todo ID has to be used
     * @return String Protection code
     */
    public function code($id = 0)
    {
        $secured_code = md5("{$this->code_prefix}{$this->table_name}{$this->protection_code}{$this->pk_column}{$this->code_suffix}");

        return $secured_code;
    }
}