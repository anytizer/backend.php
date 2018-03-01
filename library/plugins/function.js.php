<?php
#namespace plugins;

/**
 * @package Plugins
 */
/**
 * Search for a javascript.
 * Javascript files neeed to be in [/js/] directory.
 *
 * @example {js src='validate.js'}
 * @example {js base='js' src='validate.js'}
 * @example {js line='element_focus();'}
 *
 * @todo Make it as a compile time plugin
 * @todo Find the usages or remove
 */
function smarty_function_js($params = array(), &$smarty)
{
    # Examples:
    # {js base='../js' src='ajax.js|tr.js'}
    # {js src='tr_list.js'}
    # {js line="alert('hi!');"}

    $params['base'] = !empty($params['base']) ? $params['base'] : './js'; # 'smarty_templates/js';
    $params['src'] = !empty($params['src']) ? $params['src'] : "";
    $params['url'] = !empty($params['url']) ? $params['url'] : "";
    $params['validator'] = !empty($params['validator']) ? (boolean)$params['validator'] : false;

    $js = array();

    $params['line'] = !empty($params['line']) ? $params['line'] : "";
    if ($params['line'] != "") {
        # Very short term line case.
        $js[] = "<script type=\"text/javascript\">{$params['line']}</script>";
    } else {
        $srcs = explode('|', $params['src']); # Were there multiple files requested?
        foreach ($srcs as $i => $src) {
            $file = $params['base'] . '/' . $src;
            if (file_exists($file)) {
                # Checks script file immediately within ./js directory.
                $js[] = "<script src=\"{$file}\" type=\"text/javascript\"></script>";
            } else {
                /**
                 * Try to use the sub-domain server, if any.
                 * @todo Make independent
                 */
                $file = $params['base'] . '/' . $_SERVER['SERVER_NAME'] . '/' . $src;
                if (file_exists($file)) {
                    $js[] = "<script src=\"{$file}\" type=\"text/javascript\"></script>";
                } else {
                    # Search within the sub-domain pack. Do not consider PARAMS[BASE], here.
                    $subdomain_file = __SUBDOMAIN_BASE__ . '/js/' . $src;
                    if (file_exists($subdomain_file)) {
                        # .htaccess will serve this file
                        $js[] = "<script src=\"js/{$src}\" type=\"text/javascript\"></script>";
                    } else {
                        # Silently print out the missing file even from the parent
                        $js[] = "<!-- Missing JavaScript File: {$file}; Validator: {$params['validator']} -->";
                        if (!$params['validator'] && file_exists(__APP_PATH__ . '/js/' . $params['src'])) {
                            # Load the system default
                            $js[] = "<script src=\"js/{$params['src']}\" type=\"text/javascript\"></script>";
                        }
                    }
                }
            }
        }
    }

    return implode("\r\n", $js);
} # js()
