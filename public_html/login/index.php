<?php
/**
 * This is a default registration of /login/
 * It will redirect to /admin.php, which has to be registered in the database.
 * Please note that not all applications need this, or register /admin.php
 */

header('Location: ../login.php', true, 301);
