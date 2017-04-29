<?php
#namespace plugins;

/**
 * For various drop downs; Alternative to dropdown plugin
 * @url http://www.smarty.net/forums/viewtopic.php?t=14990
 *
 * @example <select name="country" id="country">{html_options options='countries'|dropdown selected=""}</select>
 */

function smarty_modifier_dropdowns($identifier = "")
{
    $data = array();

    $file = preg_replace('/[^a-z\-]+/', "", $identifier);
    $cache_file_name = __TEMP_PATH__ . '/cache-menus-dropdowns-' . $file . '.serialized';

    # Use only fresh cache files
    if (is_file($cache_file_name) && (time() - filemtime($cache_file_name) <= 12 * 60 * 60)) {
        # Using cached file is quite fast
        $data = unserialize(file_get_contents($cache_file_name));
    } else {
        # Local testing purpose before using dropdowns body from the database
        switch ($identifier) {
            case 'linkex:all-categories':
            default:
                # Pull the dropdown data from links_categories table
                $d = new \backend\dropdowns('links_categories', 'category_id', 'parent_id', 'category_name');
                $data = $d->build_array(0, 10);
        }

        # Save the file for future use
        file_put_contents($cache_file_name, serialize($data));
    }

    return $data;
}
