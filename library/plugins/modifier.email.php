<?php
#namespace plugins;

/**
 * Obfuscates an email address for showing up in the HTML.
 */
function smarty_modifier_email($email_address = "")
{
    $search = array(
        '-',
        '_',
        '@',
        '.',
    );

    $replace = array(
        '<!-- - -->(hyphen)<!-- - -->',
        '<!--_-->(underscore)<!--_-->',
        '<!--at-->(at)<!--at-->',
        '<!--dot-->(dot)<!--dot-->',
    );
    $email_address = str_replace($search, $replace, $email_address);

    return $email_address;
}
