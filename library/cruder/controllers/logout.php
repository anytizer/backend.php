<?php
#__DEVELOPER-COMMENTS__

/**
 * Logout user authentication
 */

$login = new \subdomain\login_manager();
$login->logout_user();

\common\stopper::url('./');
