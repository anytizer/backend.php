<?php
#namespace plugins;

/**
 * Shows paginated links
 *
 * @example {paginate page='page.php' total=677 per_page=30 current=3}
 * @example {paginate page='page.php' total=677 per_page=30 current=3 separator=' . '}
 */
function smarty_function_paginate($params = array(), &$smarty)
{
    # basename($_SERVER['REQUEST_URI']); # Based on our system!
    #'pages.php';
    $params['page'] = !empty($params['page']) ? $params['page'] : '?';

    # ulli / separator are mutually excluisive
    # Show UL/LI links
    # There is a comparator, not assignment
    $params['ulli'] = !empty($params['ulli']) ? $params['ulli'] === true : false;

    #$params['separator'] = !empty($params['separator'])?$params['separator']:' | ';
    #$params['separator'] = ($params['ulli'])?"":$params['separator']; # Not needed in cse of UL/LI: Cleanup them
    $params['separator'] = "\r\n";

    if (empty($params['source']) || get_class($params['source']) != 'pagination') {
        $smarty->trigger_error('Pagination source must be defined. Hints: pass <strong>pagination</strong> object only', E_USER_ERROR);

        return "";
    } else {
        #return $params['source']->show_pages($params['page'], $params['ulli'], $params['separator']);
        return $params['source']->show_pages_slider($params['page'], $params['ulli'], $params['separator']);
    }
}
