<?php
namespace subdomain;

# Created on: 2011-02-10 00:12:27 318

/**
 * licenses Class
 */

/**
 * Operations:
 *    $licenses->add()
 *        Adds a new record in licenses
 *    $licenses->edit()
 *        Modified a record in licenses
 *    $licenses->delete()
 *        Removes one of licenses record
 *    $licenses->list_entries()
 *        Fetches a list of licenses records
 *    $licenses->details()
 *        Fetches the details of licenses
 */
class licenses
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
        $this->protection_code = '7fb96469d2b1371245c193a62f8eb77f'; # Some random text, valid for the entire life
        $this->table_name = 'query_licenses'; # Name of this table/entity name
        $this->pk_column = 'license_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'application_name' => null,
                'server_name' => null,
                'protection_key' => null,
                'license_key' => null,
                'license_email' => null,
                'license_to' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'application_name' => null,
                'server_name' => null,
                'protection_key' => null,
                'license_key' => null,
                'license_email' => null,
                'license_to' => null,
            ),
        );
    }

    /**
     * List entries from [ licenses ]
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
         * And make them fit for [ licenses ] only.
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
	e.`license_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`application_name`,
	e.`server_name`,
	e.`protection_key`,
	e.`license_key`,
	e.`license_email`,
	e.`license_to`,
	
	MD5(CONCAT(`license_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_licenses` `e`
WHERE
	(
		{$conditions_compiled_AND}
	)
	AND (
		{$conditions_compiled_OR}
	)
ORDER BY
	# We assume that the sorting fields are available
	`sink_weight` ASC,
	`license_id` DESC
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
     * Details of an entity in [ licenses ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($license_id = 0)
    {
        $license_id = (int)$license_id;
        $details_sql = "
SELECT
	e.`license_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`license_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_licenses` `e`
WHERE
	`license_id` = {$license_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ licenses ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($license_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $license_id = (int)$license_id;
        $details_sql = "
SELECT
	`license_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`license_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_licenses` `e`
WHERE
	`license_id` = {$license_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`license_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($license_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $license_id = (int)$license_id;

        $flag_sql = "
UPDATE `licenses` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`license_id` = {$license_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`license_id`, '{$this->protection_code}')) = '{$protection_code}'
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