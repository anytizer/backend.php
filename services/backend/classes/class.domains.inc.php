<?php
namespace subdomain;



/**
 * domains Class
 */

/**
 * Operations:
 *    $domains->add()
 *        Adds a new record in domains
 *    $domains->edit()
 *        Modified a record in domains
 *    $domains->delete()
 *        Removes one of domains record
 *    $domains->list_entries()
 *        Fetches a list of domains records
 *    $domains->details()
 *        Fetches the details of domains
 */
class domains
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
        $this->protection_code = '0885cca95427e5139527da2dd422f557'; # Some random text, valid for the entire life
        $this->table_name = 'localhost_domains'; # Name of this table/entity name
        $this->pk_column = 'domain_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'check_after' => null,
                'response_code' => null,
                'modified_on' => null,
                'domain_name' => null,
                'url_local' => null,
                'url_live' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'check_after' => null,
                'response_code' => null,
                'modified_on' => null,
                'domain_name' => null,
                'url_local' => null,
                'url_live' => null,
            ),
        );
    }

    /**
     * List entries from [ domains ]
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
         * And make them fit for [ domains ] only.
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
	e.`domain_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`check_after`,
	e.`response_code`,
	e.`modified_on`,
	e.`domain_name`,
	e.`url_local`,
	e.`url_live`,
	
	MD5(CONCAT(`domain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `localhost_domains` `e`
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
	#`domain_id` DESC
	`domain_name` ASC
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
     * Details of an entity in [ domains ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($domain_id = 0)
    {
        $domain_id = (int)$domain_id;
        $details_sql = "
SELECT
	e.`domain_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`domain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `localhost_domains` `e`
WHERE
	`domain_id` = {$domain_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ domains ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($domain_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $domain_id = (int)$domain_id;
        $details_sql = "
SELECT
	`domain_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`domain_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `localhost_domains` `e`
WHERE
	`domain_id` = {$domain_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`domain_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($domain_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $domain_id = (int)$domain_id;

        $flag_sql = "
UPDATE `domains` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`domain_id` = {$domain_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`domain_id`, '{$this->protection_code}')) = '{$protection_code}'
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