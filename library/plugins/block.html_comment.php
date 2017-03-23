<?php
#namespace plugins;

/**
 * This is a worthless expression control to make an HTML block null.
 * Helpful for the visual page designers only, eg. Macromedia Dreamweaver
 *
 * @param $params
 * @param $content
 * @param $smarty
 * @param $repeat
 * @return null
 */
function smarty_block_html_comment($params, $content, Smarty &$smarty, &$repeat)
{
    # {comment type='html' status='on'}
    # {comment type='html' status='off'}
    # return "<!-- {$content} -->";
    # {comment}...{/comment}

    return null;
}
