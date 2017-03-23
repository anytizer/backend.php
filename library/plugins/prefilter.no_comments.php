<?php
#namespace plugins;

/**
 * Removes HTML Comments in a text
 */

function smarty_prefilter_no_comments($source = "", &$smarty)
{
    # Remove HTML Comments
    # $source = preg_replace('/<!--.*?-->/sU', "", $source);

    # Convert html tags to be lowercase.
    # $source = preg_replace('!<\/?(\w+)[^>]+>!e', 'strtolower("$1")', $source);

    return $source;
}
