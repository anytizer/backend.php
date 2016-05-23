<?php
/**
 * Resets the login requirements of a page
 */

/*
Array
(
    [page] => pages-reset-login.php
    [id] => 505
)
*/

$page_id = $variable->get('id', 'integer', 0);

$pages->reset_login_requirements($page_id);

\common\headers::back('pages-list.php');
