<?php
namespace subdomain;




/**
 * superfish Class
 */

/**
 * Operations:
 *    $superfish->add()
 *        Adds a new record in superfish
 *    $superfish->edit()
 *        Modified a record in superfish
 *    $superfish->delete()
 *        Removes one of superfish record
 *    $superfish->list_entries()
 *        Fetches a list of superfish records
 *    $superfish->details()
 *        Fetches the details of superfish
 */
class superfish
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
        $this->protection_code = 'e0607e8c50700da2b4b23efa1830596b'; # Some random text, valid for the entire life
        $this->table_name = 'query_dropdowns'; # Name of this table/entity name
        $this->pk_column = 'menu_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'subdomain_id' => 0,

                'context' => null,
                'menu_text' => null,
                'menu_link' => null,
                'menu_description' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'context' => null,
                'menu_text' => null,
                'menu_link' => null,
                'menu_description' => null,
            ),
        );
    }

    /**
     * List entries from [ superfish ]
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
	e.`menu_id`, # Do not remove this
	e.parent_id,
	
	# Modify these columns to your own list(e.*)
	e.`context`,
	e.`menu_text`,
	e.`menu_link`,
	
	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_dropdowns` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	`context`,
	`sink_weight` ASC,
	`menu_id` DESC
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
     * Details of an entity in [ superfish ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($menu_id = 0)
    {
        $menu_id = (int)$menu_id;
        $details_sql = "
SELECT
	e.`menu_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_dropdowns` `e`
WHERE
	`menu_id` = {$menu_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ superfish ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($menu_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $menu_id = (int)$menu_id;
        $details_sql = "
SELECT
	`menu_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`menu_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_dropdowns` `e`
WHERE
	`menu_id` = {$menu_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`menu_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($menu_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $menu_id = (int)$menu_id;

        $flag_sql = "
UPDATE `superfish` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`menu_id` = {$menu_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`menu_id`, '{$this->protection_code}')) = '{$protection_code}'
;";

        # return $this->query($flag_sql);
        return false; # dummy mode only
    }


    /**
     * Block actions: delete, disable, enable, prune, nothing
     * Perform a certain action in a group of IDs. Extend only if you need them
     */
    public function blockaction($action = 'nothing', $ids = array())
    {
        switch ($action) {
            case 'delete':
                # $this->blockaction_delete($ids);
                break;
            case 'disable':
                # $this->blockaction_disable($ids);
                break;
            case 'enable':
                # $this->blockaction_enable($ids);
                break;
            case 'prune':
                # $this->blockaction_prune($ids);
                break;
            case 'nothing':
            default:
                break;
        }

        return null;
    }
}