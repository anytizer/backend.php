<?php
namespace subdomain;

# Created on: 2011-03-18 13:20:47 198

/**
 * identifiers Class
 */

/**
 * Operations:
 *    $identifiers->add()
 *        Adds a new record in identifiers
 *    $identifiers->edit()
 *        Modified a record in identifiers
 *    $identifiers->delete()
 *        Removes one of identifiers record
 *    $identifiers->list_entries()
 *        Fetches a list of identifiers records
 *    $identifiers->details()
 *        Fetches the details of identifiers
 */
class identifiers
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
        $this->protection_code = 'e6851d9ae4cd7c7bc638ab43b325a814'; # Some random text, valid for the entire life
        $this->table_name = 'query_identifiers'; # Name of this table/entity name
        $this->pk_column = 'identifier_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'identifier_context' => null,
                'identifier_code' => null,
                'identifier_name' => null,
                'identifier_sql' => null,
                'identifier_comments' => null,

                'subdomain_id' => 0,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'identifier_context' => null,
                'identifier_code' => null,
                'identifier_name' => null,
                'identifier_sql' => null,
                'identifier_comments' => null,
            ),
        );
    }

    /**
     * List entries from [ identifiers ]
     * Column `code` signifies a protection code while deleting/editing a record
     *
     * @param $conditions SQL Conditions
     *
     * @return Multi-Dimensional array of entries in the list
     */
    public function list_entries(\others\condition $condition, $from_index = 0, $per_page = 50)
    {
        $crud = new \backend\crud();

        /**
         * Conditions are Compiled here so that we can manupulate them individually.
         * And make them fit for [ identifiers ] only.
         */
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
	e.`identifier_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`identifier_context`,
	e.`identifier_code`,
	e.`identifier_name`,
	e.`identifier_sql`,
	e.`identifier_comments`,
	
	MD5(CONCAT(`identifier_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_identifiers` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	#`sink_weight` ASC,
	#`subdomain_id`,
	`identifier_context`,
	`identifier_code`,
	`identifier_name` DESC
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
     * Details of an entity in [ identifiers ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($identifier_id = 0)
    {
        $identifier_id = (int)$identifier_id;
        $details_sql = "
SELECT
	e.`identifier_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`identifier_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_identifiers` `e`
WHERE
	`identifier_id` = {$identifier_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ identifiers ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($identifier_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $identifier_id = (int)$identifier_id;
        $details_sql = "
SELECT
	`identifier_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`identifier_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_identifiers` `e`
WHERE
	`identifier_id` = {$identifier_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`identifier_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($identifier_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $identifier_id = (int)$identifier_id;

        $flag_sql = "
UPDATE `query_identifiers` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`identifier_id` = {$identifier_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`identifier_id`, '{$this->protection_code}')) = '{$protection_code}'
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
        $ids = array_filter($ids, array(new \common\tools(), 'numeric_only'));
        if (!$ids) {
            # Filter that each IDs are numeric only
            return false;
        }

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