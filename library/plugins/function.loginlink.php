<?php
#namespace plugins;

/**
 * Login/Logout link
 */
function smarty_function_loginlink($params = array(), &$smarty)
{
    $link = 'login.php';
    $text = 'Login';

    if (isset($_SESSION['logged_on']) && $_SESSION['logged_on'] === true) {
        $link = 'logout.php';
        $text = 'Logout';
    }

    return "<a href=\"{$link}\">{$text}</a>";
}
