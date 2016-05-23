<?php
# Logout user authentication

$lp = new \subdomain\login_manager();
$lp->logout_user();

# Then, go to the home page
\common\stopper::url('./');
