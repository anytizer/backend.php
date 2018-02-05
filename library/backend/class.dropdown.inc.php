<?php
namespace backend;

/**
 * Makes a dropdown HTML for suferfish menu using jquery.
 * Uses menu_id/parent_id in query_dropdown tables for menu management.
 * @uses `__TEMP_PATH__`
 */
class dropdown
    extends common\mysql
{
    private $context;

    /**
     * Records to put in a Test table
     */
    #private $menu_table = '_dropdowns';

    /**
     * Production table
     */
    private $menu_table = 'query_dropdowns';
    #private $menu_table = 'query_dropdowns_test';

    /**
     * For which subdomain? And when?
     */
    private $subdomain_id = 0;
    private $added_on = 0;

    /**
     * Set the default context to load the menus from the database
     */
    public function __construct($context = "")
    {
        parent::__construct();
        $this->context = $this->safe_context($context);
        $this->added_on = time();
    }

    /**
     * Make the context safe to use.
     */
    public function safe_context($context = "")
    {
        /**
         * List of not allowed characters
         */
        $filter = '/[^a-z0-9\:\_\-]+/is';
        $context = preg_replace($filter, "", $context);
        $context = strtolower($context);

        return $context;
    }

    /**
     * Tries to use a cache file or generates the dropdown HTML
     */
    public function build($force_compile = false)
    {
        # MD5 Hash will make the filename safe
        $context_file = __TEMP_PATH__ . '/superfish-' . md5($this->context) . '.php';
        # See the readme file on: why the superfish menu contents are lost?

        if (is_file($context_file) && is_readable($context_file)) {
            $dropdown = file_get_contents($context_file);
        } else {
            # Ouch, it was not cached. Make it now.
            $dropdown = $this->make_dropdown(0, 0);

            # And, save the cache file immediately.
            file_put_contents($context_file, $dropdown);
        }

        return $dropdown;
    }



    ## Admin options only

    /**
     * Forcefully generates the dropdown HTML
     */
    private function make_dropdown($parent_id = 0, $depth = 0)
    {
        $html = "";

        $parent_id = (int)$parent_id;
        $depth = (int)$depth;

        $superfish_sql = "
SELECT
	*
FROM `{$this->menu_table}`
WHERE
	parent_id={$parent_id}
	
	# Optional? Assume context is always unique
	AND subdomain_id={$this->subdomain_id}
	
	AND menu_context='{$this->context}'
	AND is_active='Y'
	AND menu_text!=''
ORDER BY
	menu_id,
	sink_weight,
	menu_text
;";
		$rs = mysqli_query($this->CONNECTION, $superfish_sql);
		if (mysqli_num_rows($rs) > 0) {
            $html = ($depth > 0) ? "<ul>" : "<ul class=\"sf-menu\">";
            while ($menu = mysqli_fetch_assoc($rs)) {
                # Strong Debugging
                #$html .= "<li><a href=\"{$menu['menu_link']}\"><strong>{$menu['menu_id']}</strong>: {$menu['menu_text']}</a>".$this->make_dropdown($menu['menu_id'], $depth+1)."</li>";

                # Mild debugging attention
                #$html .= "<li><a href=\"{$menu['menu_link']}\">{$menu['menu_id']}: {$menu['menu_text']}</a>".$this->make_dropdown($menu['menu_id'], $depth+1)."</li>";

                # No debugging at all
                $html .= "<li><a href=\"{$menu['menu_link']}\">{$menu['menu_text']}</a>" . $this->make_dropdown($menu['menu_id'], $depth + 1) . "</li>";
            }
            $html .= "</ul>";
        }

		return $html;
	}

    /**
     * Current context
     */
    public function context()
    {
        return $this->context;
    }

    /**
     * Quickly parse menus context. This is a very sensitive information.
     * Use carefully.
     */
    public function quick_parse($dropdown_excel_tsv = "", $subdomain_id = 0)
    {
        # Delete the temp file
        $cache = __TEMP_PATH__ . '/superfish-' . md5($this->context) . '.php';
        if (is_file($cache)) {
            unlink($cache);
        }

        $menus = preg_split("/[\r|\n]+/is", $dropdown_excel_tsv);
        $menus = array_filter($menus);

        # Beginning
        $parents = array(
            'menu_id' => 'NULL',
            'parent_id' => 0
        );

        $this->subdomain_id($subdomain_id);
        $this->clean_context($this->context);

        $menu_id_current = 0;
        $parent_id_next = 0;

        $current_depth = 0;
        $last_depth = 0;

        #print_r($menus); die();
        foreach ($menus as $m => $menu_tsv) {
            $last_depth = $current_depth;
            $current_depth = $this->find_depth($menu_tsv);

            # Now entered, is being: child, sibling or other parents
            if ($current_depth == 0) {
                # New parent
                #echo("\nNew parent...");
                $menu_id_current = 0;
                $parent_id_next = 0;
            } else if ($current_depth > $last_depth) {
                # Child!
                #echo("\nChild...");
                $parent_id_next = $this->parent_id_for_child($menu_id_current);
            } else if ($current_depth == $last_depth) {
                # Sibling
                #echo("\nSibling...");
                $parent_id_next = $this->parent_id_of_sibling_id($menu_id_current);
            } else if ($current_depth < $last_depth) {
                # Other next parent
                #echo("\nOther next parent: Same offsprings... {$menu_id_current}...");
                #$parent_id = $menu_id_current; # At leaset working
                $parent_id_next = $this->parent_id($parents[1]); # Perfect one
                #print_r($parents);
                #die('Go to grand parent as: '.$parent_id_next);
            }

            $menu = $this->parse_tsv($menu_tsv);
            #echo "\r\n", "{$current_depth}:$last_depth ",  implode(" == ", $menu);

            $parents = array(
                'menu_id' => $menu_id_current,
                'parent_id' => $parent_id_next
            );
            $parents = $this->add_menu($menu, $parents, $this->context);
            #print_r($parents); #die();
        } # foreach

    }

    /**
     * Set a subdomain
     * @todo Deprecate it
     */
    public function subdomain_id($subdomain_id = 0)
    {
        $subdomain_id = (int)$subdomain_id;
        if ($subdomain_id) {
            $this->subdomain_id = $subdomain_id;
        }

        return $this->subdomain_id;
    }

    /**
     * As we are modifying/adding a new context, just remove the older data, if any.
     */
    public function clean_context($context = 'DEFAULT')
    {
        $context = $this->safe_context($context);
        $delete_context_sql = "DELETE FROM `{$this->menu_table}` WHERE subdomain_id={$this->subdomain_id} AND `context` = '{$context}';";

        #$delete_context_sql="TRUNCATE `{$this->menu_table}`;";
        return $this->query($delete_context_sql);
    }

    /**
     * Determines the depth of a menu, by counting its leading tabs.
     * Leading tabs (each tab means a depth from its parent.
     */
    public function find_depth($menu_tsv = "")
    {
        $data = array();
        preg_match_all('/^(\t+)/is', $menu_tsv, $data, PREG_SET_ORDER);
        if (!isset($data[0][1])) {
            $data[0][1] = "";
        }
        $depth = strlen($data[0][1]);

        return $depth;
    }

    /**
     * Get the parent_id for a child
     */
    public function parent_id_for_child($menu_id = 0)
    {
        $menu_id = (int)$menu_id;
        $parent_id_sql = "SELECT MAX(menu_id) FROM `{$this->menu_table}` WHERE is_active='Y';";

        #echo("\nFind child parent: <strong>{$menu_id}</strong>: {$parent_id_sql}");
        return $this->record_node($parent_id_sql);
    }

    /**
     * First column (single column or multi column data)
     */
    private function record_node($sql = "")
    {
        $rs = mysqli_query($this->CONNECTION, $sql);
        $row = mysqli_fetch_array($rs, MYSQL_NUM);
        if (!isset($row[0])) {
            # Absence means the root node, always!
            #$row[0] = false;
            $row[0] = 0;
        }
        if (count($row) == 1) {
            # Single Column, means the immediate value
            return $row[0];
        } else {
            # Multi columns mean the whole array
            return $row;
        }
    }

    /**
     * Get the parent_id for a sibling
     */
    public function parent_id_of_sibling_id($menu_id = 0)
    {
        $menu_id = (int)$menu_id;
        $parent_id_sql = "
SELECT
	parent_id
FROM `{$this->menu_table}`
WHERE
	menu_id = (SELECT MAX(menu_id) FROM `{$this->menu_table}`)
	AND is_active='Y'
;";

        return $this->record_node($parent_id_sql);
    }

    /**
     * Get the parent_id for a child
     */
    public function parent_id($menu_id = 0)
    {
        $menu_id = (int)$menu_id;
        $parent_id_sql = "SELECT parent_id FROM `{$this->menu_table}` WHERE menu_id={$menu_id} AND is_active='Y';";

        #die($parent_id_sql);
        return $this->record_node($parent_id_sql);
    }

    /**
     * Reads an TSV from excel sheet for individual records
     */
    public function parse_tsv($menu_tsv = "")
    {
        $tsv_original = preg_split('/\t/is', $menu_tsv);
        $tsv = array_values(array_filter($tsv_original));
        if (empty($tsv[1])) {
            $tsv[1] = '#'; # Link URL
        }

        return $tsv;
    }

    /**
     * Pushes a menu into the database
     */
    public function add_menu($menu = array(), $parents = array(), $context = 'DEFAULT')
    {
        $context = $this->safe_context($context);
        $parents['menu_id'] = (int)$parents['menu_id'];
        if (!$parents['menu_id']) {
            # The NULL entry in SQL will create a new menu_id
            $parents['menu_id'] = 'NULL';
        }
        $parents['parent_id'] = (int)$parents['parent_id'];
        $menu[0] = addslashes($menu[0]);
        $menu[1] = addslashes($menu[1]);

        #`menu_id`,
        #{$parents['menu_id']},

        #`sink_weight`, `is_active`,
        #'99', 'Y',

        $menu_add_sql = "
INSERT INTO `{$this->menu_table}` (
	`subdomain_id`,
	`parent_id`,
	`menu_context`,
	`menu_text`,`menu_link`,
	`added_on`, `is_active`
) VALUES (
	{$this->subdomain_id},
	'{$parents['parent_id']}',
	'{$context}',
	'{$menu[0]}', '{$menu[1]}',
	'{$this->added_on}', 'Y'
);";
        #echo($menu_add_sql);
        $this->query($menu_add_sql);

        # Return the menu_id and parent_id info
        $parent_id_sql = "SELECT menu_id, parent_id FROM `{$this->menu_table}` WHERE menu_id = (SELECT MAX(menu_id) FROM `{$this->menu_table}`);";

        return $this->record_node($parent_id_sql);
    }
}