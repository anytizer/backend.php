<?php
#namespace plugins;

/**
 * Back trace debugger
 */
function smarty_function_trace($params = array(), &$smarty)
{
    #debug_print_backtrace();
    print_r(debug_backtrace());
}
