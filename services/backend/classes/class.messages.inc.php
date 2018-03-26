<?php
namespace subdomain;




/**
 * messages Class
 */

/**
 * Operations:
 *    $messages->add()
 *        Adds a new record in messages
 *    $messages->edit()
 *        Modified a record in messages
 *    $messages->delete()
 *        Removes one of messages record
 *    $messages->list_entries()
 *        Fetches a list of messages records
 *    $messages->details()
 *        Fetches the details of messages
 */
class messages
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
        $this->protection_code = '47e2402a9b53e083ac5435ddd98d066e'; # Some random text, valid for the entire life
        $this->table_name = 'query_messages'; # Name of this table/entity name
        $this->pk_column = 'message_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            # Remove the columns that you do not want to use in the ADD form
            'add' => array(
                'subdomain_id' => 0,
                'message_code' => null,
                'message_status' => null,
                'message_body' => null,
            ),

            # Remove the columns that you do not want to use in the EDIT form
            'edit' => array(
                'message_status' => null,
                'message_body' => null,
            ),
        );
    }

    /**
     * List entries from [ messages ]
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
         * And make them fit for [ messages ] only.
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
	e.`message_id`, # Do not remove this
	e.subdomain_id,
	
	# Modify these columns to your own list(e.*)
	e.`message_code`,
	e.`message_status`,
	e.`message_body`,
	
	MD5(CONCAT(`message_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_messages` `e`
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
	`message_id` DESC
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
     * Details of an entity in [ messages ] for management activities
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function details($message_id = 0)
    {
        $message_id = (int)$message_id;
        $details_sql = "
SELECT
	e.`message_id`, # Do not remove this

	e.*, # Modify these columns,
	
	# Admin must have it to EDIT the records
	MD5(CONCAT(`message_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_messages` `e`
WHERE
	`message_id` = {$message_id}
;";
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Details of an entity in [ messages ] for public display.
     *
     * @param $pk integer Primary Key's value of an entity
     *
     * @return $details Associative Array of Detailed records of an entity
     */
    public function get_details($message_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $message_id = (int)$message_id;
        $details_sql = "
SELECT
	`message_id`, # Do not remove this

	e.*, # Modify these columns

	MD5(CONCAT(`message_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_messages` `e`
WHERE
	`message_id` = {$message_id}
	AND e.is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`message_id`, '{$this->protection_code}')) = '{$protection_code}'
;";
        $details = $this->row($details_sql);

        return $details;
    }


    /**
     * Flag a field; dummy use; unless you use it.
     * Every method should sanitize the user input.
     * It will co-exist with the live features.
     */
    public function flag_dummyfield($message_id = 0, $protection_code = "")
    {
        $protection_code = $this->sanitize($protection_code);
        $message_id = (int)$message_id;

        $flag_sql = "
UPDATE `query_messages` SET
	# Set your flag name here
	flag_name=IF(flag_name='Y', 'N', 'Y')
WHERE
	`message_id` = {$message_id}
	
	# Don't touch the deleted flags
	AND is_active='Y'

	# Optionally validate
	AND MD5(CONCAT(`message_id`, '{$this->protection_code}')) = '{$protection_code}'
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

    /**
     * Welcome and ask for authentication?
     * Please extend this method according to your business logic.
     * Used right after a new \subdomain\messages is added.
     */
    public function welcome_first($message_id = 0)
    {
        $message_id = (int)$message_id;

        return true;
    }
}