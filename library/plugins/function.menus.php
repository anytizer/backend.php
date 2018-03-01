<?php
#namespace plugins;

/**
 * Loads HTML menus/links from the database.
 * Useful in placing grouped menus together.
 * Allows sorting of the links.
 * Supports interal / enternal links (database defined targets).
 * Has prefix/suffix strings.
 * Has database defined class name
 */

function smarty_function_menus($params = array(), &$smarty)
{
    $menu_output = ""; # Output store
    #print_r($_SESSION); print_r($_GET); print_r($params);

    $menu_id = 0;
    if (isset($_GET['cid'])) {
        $menu_id = (int)$_GET['cid'];
    } else if (isset($_SESSION['cid'])) {
        # Use it as the last selected active tab
        # Helps in implementing multiple sub-tabs using a different index like cid.
        # cid = Context ID
        # tip = Sub Tab ID
        $menu_id = (int)$_SESSION['cid'];
    } else {
        $menu_id = isset($params['cid']) ? (int)$params['cid'] : 0;
    }
    $_SESSION['cid'] = $menu_id; # Save it for future use.

    # left, right, top
    # It should be a unique context over all subdomains installed/used.
    $params['context'] = \common\tools::safe_sql_word(isset($params['context']) ? $params['context'] : '--nothing--');

    $params['prefix'] = isset($params['prefix']) ? $params['prefix'] : '<li>';
    $params['suffix'] = isset($params['suffix']) ? $params['suffix'] : '</li>';

    # Not yet tested for caching
    $params['cache'] = (isset($params['cache']) && in_array(strtolower($params['cache']), array('true', 'yes', true)));

    $cache_file = __TEMP_PATH__ . '/cache-menus-' . \common\tools::filename($params['context']) . '.php'; # Store here.

    if (file_exists($cache_file) && $params['cache']) {
        # Some dynamically coded menus are still unable to show the currently chosen menus when
        # included from a flat file.
        $menu_output = file_get_contents($cache_file);
    } else {
        # Bind a sub-domain specific menus?
        # But admin should be able to load other's menus as well.
        # Hence, at the moment, just use the menu context.
        $subdomain_id = 0;
        # $framework = new \backend\framework();
        # $subdomain_id = $framework->subdomain_id();

        $menus_sql = "
SELECT
	m.menu_id menu_id,
	TRIM(m.menu_text) text, # LOWER CASE: TEXT/text
	TRIM(m.menu_link) href,
	TRIM(m.link_target) target,
	TRIM(m.html_class) class,
	TRIM(m.html_id) id,
	TRIM(m.html_alt) alt,
	TRIM(m.html_title) title
FROM query_menus m
WHERE
	# Do not force to use a sub-domain ID
	# But use it in a leased script.
	# m.subdomain_id={$subdomain_id}

	# Asume that context is uniquely binding menus
	m.menu_context='{$params['context']}'
	AND m.is_active='Y'
ORDER BY
	m.sink_weight ASC,
	m.menu_text ASC,
	m.menu_id ASC
;";
        $db = new \common\mysql();

        $db->query($menus_sql);
        $menus = array();
        while ($menu = $db->row("")) {
            # Capitalize the first words?
            # Don't be oversmart. Let the user manage it within the database.
            # $menu['mt'] = ucwords($menu['mt']);

            $id_class = ($menu_id == $menu['menu_id']) ? ' current' : "";

            $strings = array();
            $strings[] = ($menu['target']) ? "target=\"{$menu['target']}\"" : null;
            $strings[] = ($menu['class'] || $id_class) ? "class=\"{$menu['class']}{$id_class}\"" : null;
            $strings[] = ($menu['id']) ? "id=\"{$menu['id']}\"" : null;
            $strings[] = ($menu['title']) ? "title=\"{$menu['title']}\"" : null;
            if ($menu_id !== null) {
                #Remove last & in menu
                $menu['href'] = preg_replace('/\#.*?$/is', "", $menu['href']);
                $menu['href'] = preg_replace('/\&$/is', "", $menu['href']);
                $menu['href'] = preg_replace('/\?/is', "", $menu['href']);
                $menu['href'] = preg_replace('/\=$/is', "", $menu['href']);
                if (strpos($menu['href'], '?') !== false) {
                    # ? found in the URL: Just apped our CID
                    $strings[] = "{$menu['href']}&cid={$menu['menu_id']}\"";
                } else {
                    $strings[] = ($menu['href']) ? "href=\"{$menu['href']}?cid={$menu['menu_id']}\"" : null;
                }
            } else {
                # CID is not necessary. Use the plain link only
                $strings[] = ($menu['href']) ? "href=\"{$menu['href']}\"" : null;
            }
            $strings[] = ($menu['alt']) ? "alt=\"{$menu['alt']}\"" : null;
            $attributes = implode(' ', array_filter($strings));

            $menus[] = "{$params['prefix']}<a {$attributes}><span>{$menu['text']}</span></a>{$params['suffix']}";
        }

        $menu_output = implode("", $menus);
        file_put_contents($cache_file, $menu_output);
    } # if

    return $menu_output;
}
