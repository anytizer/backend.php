<?php
#namespace plugins;

/**
 * Remote CSS Fetcher - works only in the compile time
 * Output html containing the link to remote css file without affecting the design
 * @file compiler.remote_css.php
 * @type compiler
 * @name remote_css
 * @url http://www.smarty.net/forums/viewtopic.php?p=61096#61096
 * @example {remote_css href='css/styles.css'}
 *
 * @param $tag_attrs
 * @param $compiler
 * @return null|string
 */
function smarty_compiler_remote_css($tag_attrs, &$compiler)
{
    $_params = $compiler->_parse_attrs($tag_attrs);

    if (!isset($_params['href'])) {
        $compiler->_syntax_error("assign: missing 'href' parameter", E_USER_WARNING);

        return null;
    }

    return "echo {$_params['href']};";
}
