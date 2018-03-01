<?php
namespace backend;
use Exception;
use \abstracts\entity;
use \backend\crud;

    /**
     * @todo Remove this file's extra items.
     * @see \subdomain\pages
     */

# Created on: 2010-09-16 18:44:59 443

/**
 * Operations:
 *    $pages->add()
 *        Adds a new record in pages
 *    $pages->edit()
 *        Modified a record in pages
 *    $pages->delete()
 *        Removes one of pages record
 *    $pages->list_entries()
 *        Fetches a list of pages records
 *    $pages->details()
 *        Fetches the details of pages
 */
class pages
    extends entity
{
    /**
     * Optional Constructor: Load on demand only.
     */
    public function __construct()
    {
        /**
         * Set Private, Protected or Public Members
         */
        $this->protection_code = '388421072c9965a82f0ecf870d74e468'; # Some random text, valid for the entire life
        $this->table_name = 'query_pages'; # Name of this table/entity name
        $this->pk_column = 'page_id'; # Primary Key's Column Name

        /**
         * Validation fields as used in add/edit forms
         */
        $this->fields = array(
            'add' => array(
                'subdomain_id' => "",
                'page_name' => "",
                'page_title' => "",
                'meta_keywords' => "",
                'meta_description' => "",
                'content_title' => "",
                'content_text' => "",
                'include_file' => "",
            ),
            'edit' => array(
                'subdomain_id' => "",
                'page_name' => "",
                'page_title' => "",
                'meta_keywords' => "",
                'meta_description' => "",
                'content_title' => "",
                'content_text' => "",
                'include_file' => "",
            ),
        );

        parent::__construct();
    }


    /**
     * List entries from [ pages ]
     * Column `code` signifies a protection code while deleting/editing a record
     *
     * @param \others\condition $condition
     * @param int $from_index
     * @param int $per_page
     * @return array
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
    `page_id`, # Do not remove this

    # Modify these columns
    e.*,

    MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code` # Protection Code
FROM `query_pages` `e`
WHERE
    (
        {$conditions_compiled_AND}
    )
    AND (
        {$conditions_compiled_OR}
    )
LIMIT {$from_index}, {$per_page}
;";

# Extra
#    e.user_id = {$variable->session('user_id', 'integer', 0)}
#    AND e.is_active = 'Y'

        /*
                $listing_sql="
        SELECT SQL_CALC_FOUND_ROWS
            `page_id`, # Do not remove this

            # Modify these columns
            e.*,

            MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code` # Protection Code
        FROM `query_pages` `e`
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
     * Details of an entity in [ pages ] for management activities
     *
     * @param int $page_id
     * @return array
     */
    public function details($page_id = 0)
    {
        $page_id = (int)$page_id;
        $details_sql = "
SELECT
    `page_id`, # Do not remove this

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
     * Details of an entity in [ pages ] for public display.
     *
     * @param int $page_id
     * @param string $protection_code
     * @return array
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
     * Shows all pages to list out
     *
     * @param int $subdomain_id
     * @return array
     */
    public function list_pages($subdomain_id = 0)
    {
        $subdomain_id = (int)$subdomain_id;
        $specific_subdomain_sql = ($subdomain_id) ? 'AND subdomain_id=' . $subdomain_id : "";

        $pages_sql = "
SELECT
	page_id `i`,
	page_name `n`,
	page_title `t`,
	needs_login `nl`,
	is_admin `ia`
FROM query_pages
WHERE
	is_active='Y'
	{$specific_subdomain_sql}
ORDER BY
	page_name
;";
        $this->query($pages_sql);
        $pages = $this->to_array();

        return $pages;
    }


    /**
     * For sorting
     *
     * @param int $subdomain_id
     * @return array
     */
    public function list_pages_for_sorting_in_sitemap($subdomain_id = 0)
    {
        $subdomain_id = (int)$subdomain_id;
        $specific_subdomain_sql = ($subdomain_id) ? 'AND subdomain_id=' . $subdomain_id : "";

        $pages_sql = "
SELECT
	page_id,
	page_name,
	page_title,
	sink_weight,
	MD5(CONCAT(`page_id`, '{$this->protection_code}')) `code`
FROM query_pages
WHERE
	subdomain_id={$subdomain_id}
	AND is_active='Y'
	AND in_sitemap='Y'
ORDER BY
	sink_weight,
	page_name
;";
        $this->query($pages_sql);
        $pages = $this->to_array();

        return $pages;
    }

    /**
     * Fetches details of a page
     */
    public function list_details($page_id = 0)
    {
        $page_id = (int)$page_id;
        $details_sql = "
SELECT
	p.*
FROM query_pages p
WHERE
	p.page_id={$page_id}
;";
        #\common\stopper::message($details_sql);
        $details = $this->row($details_sql);

        return $details;
    }

    /**
     * Saves a page details
     *
     * @param int $page_id
     * @return int
     */
    public function save($page_id = 0)
    {
        $page_id = (int)$page_id;
        $crud = new \backend\crud();
        $variable = new \common\variable();
        $success = $crud->update(
            'query_pages',
            array_merge(
                $variable->post('page', 'array', array()),
                array(
                    'modified_counter' => 'modified_counter+1',
                )
            ),
            array(
                'page_id' => $page_id,
            )
        );

        return $success;
    }

    /**
     * Checks if a page name exists in a subdomain
     *
     * @param int $subdomain_id
     * @param string $filename
     * @return mixed
     */
    public function if_page_exists($subdomain_id = 0, $filename = "")
    {
        $subdomain_id = (int)$subdomain_id;
        $filename = \common\tools::php_filename($filename);
        #\common\stopper::message("Testing: {$subdomain_id} - {$filename}");

        # 0  = Page does not exist already. So, valid.
        # 1+ = Page exists already. So, new same name should be rejected.
        $page_exists_check_sql = "
SELECT
	COUNT(*)=0 `valid`
FROM query_pages
WHERE
	subdomain_id={$subdomain_id}
	AND page_name='{$filename}'
;";
        #\common\stopper::message($page_exists_check_sql);

        $exists = $this->row($page_exists_check_sql);

        return $exists['valid'];
    }

    /**
     * Sends page details - static contents defined in the database.
     * @todo Make use of alias ID in subdomain_name
     *
     * @param string $page_name
     * @return array
     * @throws Exception
     */
    public function get_current_page($page_name = "")
    {
        $page_name = addslashes($page_name);
        if(!$page_name)
        {
            $page_name = "/";
        }
        $subdomain_name = addslashes($_SERVER['SERVER_NAME']);
        $page_details_sql = "
SELECT
	qs.is_down,
	qs.is_https,
	qs.is_www,
	qp.*
FROM query_pages qp
INNER JOIN query_subdomains qs ON
	qs.subdomain_id = qp.subdomain_id
	AND qs.subdomain_name='{$subdomain_name}'
	AND qp.page_name='{$page_name}'
	AND qs.is_active='Y'
	AND qp.is_active='Y'
;";
        $page_details = $this->row($page_details_sql);
        #echo $page_details_sql;

        if (!$page_details) {
            /**
             * @todo Send 404 Header and Log the page title and sub-domain name, HTTP REFERER
             */
            throw new Exception("Domain [{$subdomain_name}] has not registered page [/{$page_name}].");
        }
        $this->update_counter($page_details['page_id']);

        return $page_details;
    }

    /**
     * Internal records on how many times a page is served for.
     * You may extend this feature to keep details for information.
     * Like, time, date, ip, page, user id, ...
     *
     * @param $page_id
     * @return bool
     */
    private function update_counter($page_id)
    {
        $page_id = (int)$page_id;
        $update_spy_sql = "
UPDATE query_pages SET
	page_counter = page_counter+1,
	accessed_on=CURRENT_TIMESTAMP()
WHERE
	page_id={$page_id}
;";

        return $this->query($update_spy_sql);
    }

    /**
     * For blank sub-domain ID, draw one from current subdomain
     * @todo Deprecate this and rather use $subdomain_id. Only one page using it.
     * @see framework::subdomain_id()
     *
     * @return mixed
     */
    function subdomain_id_for_current_subdomain()
    {
        $subdomain_id_sql = "
SELECT
	`subdomain_id` `id`
FROM `query_subdomains`
WHERE
	`subdomain_name`='{$_SERVER['SERVER_NAME']}'
;";
        if ($sub-domain = $this->row($subdomain_id_sql)) {
        } else {
            $sub-domain = array('id' => 0);
        }

        return $subdomain['id'];
    }

    /**
     * Reset login requirements on a particular page
     */
    public function reset_login_requirements($page_id = 0)
    {
        $page_id = (int)$page_id;
        $login_reset_sql = "
UPDATE query_pages SET
	needs_login = IF(needs_login='Y', 'N', 'Y')
WHERE
	page_id={$page_id}
	AND is_active='Y'
;";

        return $this->query($login_reset_sql);
    }


    /**
     * Reset ADMIN Login requirements on a particular page
     *
     * @param int $page_id
     * @return bool
     */
    public function reset_admin_login_requirements($page_id = 0)
    {
        $page_id = (int)$page_id;
        $login_reset_sql = "
UPDATE query_pages SET
	is_admin = IF(is_admin='Y', 'N', 'Y')
WHERE
	page_id={$page_id}
	AND is_active='Y'
;";

        return $this->query($login_reset_sql);
    }


    /**
     * Reset ADMIN Login requirements on a particular page
     *
     * @param int $page_id
     * @return bool
     */
    public function reset_sitemap($page_id = 0)
    {
        $page_id = (int)$page_id;
        $reset_sql = "
UPDATE query_pages SET
	in_sitemap = IF(in_sitemap='Y', 'N', 'Y')
WHERE
	page_id={$page_id}
	AND is_active='Y'
;";

        return $this->query($reset_sql);
    }

    /**
     * Lists out how many files are produced so far in each subdomains.
     *
     * @return array
     */
    public function statistics()
    {
        $statistics_sql = "
SELECT
	s.subdomain_name subdomain,
	s.subdomain_id,
	COUNT(p.page_id) pages
FROM query_pages p
INNER JOIN query_subdomains s ON
	s.subdomain_id = p.subdomain_id
	AND s.is_active='Y'
	AND p.is_active='Y'
GROUP BY
	s.subdomain_id
ORDER BY
	s.subdomain_name
;";

        return $this->arrays($statistics_sql);
    }
}
