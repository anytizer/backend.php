<?php
/**
 * Resets the ADMIN Login requirements of a page
 */

$page_id = $variable->get('id', 'integer', 0);

$pages->reset_admin_login_requirements($page_id);

\common\headers::back('pages-list.php');
