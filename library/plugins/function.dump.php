<?php
#namespace plugins;

/**
 * Debugs a variable: VARDUMP.
 * @todo Find the usages or remove
 *
 * @example {dump var=$variabe}
 */

function smarty_function_dump($params = array(), &$smarty)
{
    $params['var'] = isset($params['var']) ? $params['var'] : null;
    $dump = '<pre>' . var_export($params['var'], true) . '</pre>';

    return $dump;
}
