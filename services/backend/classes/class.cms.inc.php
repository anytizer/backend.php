<?php
namespace subdomain;

# Created on: 2011-02-09 23:25:11 836

/**
 * cms Class
 */

/**
 * Operations:
 *    $cms->add()
 *        Adds a new record in cms
 *    $cms->edit()
 *        Modified a record in cms
 *    $cms->delete()
 *        Removes one of cms record
 *    $cms->list_entries()
 *        Fetches a list of cms records
 *    $cms->details()
 *        Fetches the details of cms
 */
class cms
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
        $this->protection_code = '37070a9a813f7145d5ebedcf14b87737'; # Some random text, valid for the entire life
        $this->table_name = 'query_pages'; # Name of this table/entity name
        $this->pk_column = 'page_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'page_name' => null,
                'page_title' => null,
                'include_file' => null,
                'content_title' => null,
                'content_text' => null,
                'meta_keywords' => null,
                'meta_description' => null,
                'template_file' => null,
                'page_comments' => null,
                'page_extra' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'page_name' => null,
                'page_title' => null,
                'include_file' => null,
                'content_title' => null,
                'content_text' => null,
                'meta_keywords' => null,
                'meta_description' => null,
                'template_file' => null,
                'page_comments' => null,
                'page_extra' => null,
            ),
        );
    }

    /**
     * List entries from [ cms ]
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
         * And make them fit for [ cms ] only.
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
	e.`page_id`, # Do not remove this
	
	# Modify these columns to your own list(e.*)
	e.`page_name`,
	e.`page_title`,
	e.`include_file`,
	e.`content_title`,
	e.`meta_keywords`,
	e.`template_file`,
	e.`page_comments`,
	e.`page_extra`,
	
	MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_pages` `e`
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
	#`page_id` DESC
	page_name
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
     * Details of an entity in [ cms ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($page_id = 0)
    {
        $page_id = (int)$page_id;
        $details_sql = "
SELECT
	e.`page_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_pages` `e`
WHERE
	`page_id` = {$page_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ cms ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($page_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $page_id = (int)$page_id;
        $details_sql = "
SELECT
	`page_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_pages` `e`
WHERE
	`page_id` = {$page_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`page_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($page_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $page_id = (int)$page_id;

        $flag_sql = "
UPDATE `cms` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`page_id` = {$page_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`page_id`, '{$this->protection_code}')) = '{$protection_code}'
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