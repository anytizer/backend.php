<?php
# Read sub-domain specific configuration file
$service_config_file = __SUBDOMAIN_BASE__ . '/config.php';
#require_once($service_config_file);

$controller_location = __SUBDOMAIN_BASE__ . '/controllers';

# Try to load the service specific config file,
# as defined globally in library/inc/inc.config.php
if (isset($service_config_file) && file_exists($service_config_file) && is_file($service_config_file)) {
    # Needed only for sub-domain services. Used before the controllers.
    # Pattern: /SERVER_NAME/config.mysql.inc.php
    require_once($service_config_file);
}

# If file name does not contain, '/' character,
# it is NOT having a no-directory instructions.
if (($valid_file_name = \common\tools::php_filename($page)) == "") {
    \common\stopper::message("Invalid filename/php: <strong>{$page}</strong>. It should pass \common\tools::php_filename().");
}

$controller_file = $controller_location . '/' . $valid_file_name;
if (file_exists($controller_file) && is_file($controller_file)) {
    # Try to use this kind of controller file
    require_once($controller_file);
} else {
    # For development only, it should not be active in production version.
    # It helps to group a set of files in their own directories.
    # Example: "/mysql-backup.php" is located in: "/mysql/backup.php".
    # Example: "/mysql-backup-everything.php" is located in: "/mysql/backup-everyting.php".
    # Valid actions in an entity are:
    #    add
    #    delete
    #    details
    #    details-public
    #    edit
    #    list
    #    list-public
    # There are other parameters as well.
    # Please refer to sqls/install-entity.sql for more details.
    # And, if you add your own actions, it will follow the same patterns.

    $controller_pattern = '/\/([a-z0-9]+)\-([a-z0-9\-]+)\.php$/';
    $controller_file_new = preg_replace($controller_pattern, '/$1/$2.php', $controller_file);
    if (file_exists($controller_file_new) && is_file($controller_file_new)) {
        # Use the controller file
        require_once($controller_file_new);
    } else {
        # Handle the absence of controller files.
        # Absenteeism is valid even in production mode.
        # When a controller is absent, it cannot interact with GET/POST or other calculations.
        # \common\stopper::message('None of the controllers exist:<br>1. '.$controller_file.',<br>2. '.$controller_file_new);
    }
}
