<?php
/**
 * @todo Bootstrap configurations should be loaded earlier.
 */
define("__ROOT_PATH__", realpath(dirname(__FILE__) . "/.."));
chdir(__ROOT_PATH__);

require_once(__ROOT_PATH__ . "/inc.bootstrap.php");

$database_config_file = "{$backend["paths"]["__APP_PATH__"]}/database/config.mysql.inc.php";
if (is_file($database_config_file)) {
    /**
     * Do not overwrite the database configuration file.
     */
    // throw new \Exception("Your configuration file exists already at: {$database_config_file}");
    die("Your configuration file exists already at: {$database_config_file}");
}

/**
 * Verify that all of the installation paths are available for write-mode
 */
$checks = array(
    $backend["paths"]["__APP_PATH__"] . "/database",
    $backend["paths"]["__SERVICES_PATH__"],
    $backend["paths"]["__TEMP_PATH__"],
    # Need to overwrite the default settings in those configurations as well
    # $database_config_file,
);

$errors = array();
foreach ($checks as $c => $check) {
    if (!is_writable($check)) {
        $errors[] = "touch {$check}";
        $errors[] = "<strong>chmod -R 777 {$check}</strong>";
    }
}
if ($errors) {
    die("<p>Error! Please do the following touch first:</p>" . implode("\r\n<br />", $errors));
}

require_once(__ROOT_PATH__ . "/install/inc.config.php");
require_once(__ROOT_PATH__ . "/install/class.installer.inc.php");

$installer = new installer();

$license_key = $installer->license_key;
$license_text = "
[BACKEND]
    APPLICATION=\"BACKEND FRAMEWORK\"
    COMPANY_NAME=\"{$installer->company_name}\"
    INSTALLED_ON=\"{$installer->installed_on}\"REPLACE_
    SERVER_NAME=\"{$installer->server_name}\"
    LICENSE_KEY=\"{$installer->license_key}\"
    LICENSE_DATABASE=\"{$config["MYSQLDATABASE"]}\"
";

# Generate a license key and lock the installer
$license_file = "{$backend["paths"]["__APP_PATH__"]}/database/license.ini";
if (!is_file($license_file)) {
    if (is_writable(dirname($license_file))) {
        if (!file_put_contents($license_file, $license_text)) {
            die("<p>Cannot write the below contents to: <strong>{$license_file}</strong></p>" . nl2br($license_text));
        }
    } else {
        die("<p>Please make writable: <strong>{$license_file}</strong> or write the contents:</p>" . nl2br($license_text));
    }
} else {
    # The license file exists.
    # Verify it or just skip.
    $license = parse_ini_file($license_file, true);

    $database_ini_file = "{$backend["paths"]["__APP_PATH__"]}/{$license["BACKEND"]["LICENSE_DATABASE"]}/{$license["BACKEND"]["LICENSE_DATABASE"]}.ini";
    if (!is_file($database_ini_file)) {
        die("Remove your license file and continue.");
    }
    $database = parse_ini_file($database_ini_file, true);

    /**
     * Read back the configurations
     */
    $config["MYSQLHOSTNAME"] = $database["DATABASE"]["HOSTNAME"];
    $config["MYSQLUSERNAME"] = $database["DATABASE"]["USERNAME"];
    $config["MYSQLPASSWORD"] = $database["DATABASE"]["PASSWORD"];
    $config["MYSQLDATABASE"] = $database["DATABASE"]["DATABASE"];
}


$scripts_source = __ROOT_PATH__ . "/install/sql-scripts";
$scripts_destination = "{$backend["paths"]["__APP_PATH__"]}/database/{$config["MYSQLDATABASE"]}";
if (!is_dir($scripts_destination)) {
    mkdir($scripts_destination, 0777, true);
}

function next_id($name = "")
{
    static $next_filename_id = 0;
    ++$next_filename_id;

    return str_pad($next_filename_id, 2, "0", STR_PAD_LEFT) . "-" . $name;
}

function replace_sql_credentials($credentials = "")
{
    global $config;
    $credentials = preg_replace("/REPLACE_MYSQLHOSTNAME/i", $config["MYSQLHOSTNAME"], $credentials);
    $credentials = preg_replace("/REPLACE_MYSQLDATABASE/i", $config["MYSQLDATABASE"], $credentials);
    $credentials = preg_replace("/REPLACE_MYSQLUSERNAME/i", $config["MYSQLUSERNAME"], $credentials);
    $credentials = preg_replace("/REPLACE_MYSQLPASSWORD/i", $config["MYSQLPASSWORD"], $credentials);

    return $credentials;
}

# Pre-Installation files
$pre_install = file_get_contents("{$scripts_source}/pre-install.sql");
$pre_install = replace_sql_credentials($pre_install);
$pre_installer = "{$scripts_destination}/" . next_id("pre-install-{$config["MYSQLDATABASE"]}.sql");
file_put_contents($pre_installer, $pre_install) or die("Cannot write to Pre-Install file: " . $pre_installer);

# Main Installation files (Windows)
$install = file_get_contents("{$scripts_source}/install.bat");
$install = replace_sql_credentials($install);
$installer = "{$scripts_destination}/" . next_id("install-{$config["MYSQLDATABASE"]}.bat");
file_put_contents($installer, $install) or die("Cannot write to Installer: " . $installer);

# Main Installation files (Linux)
$install = file_get_contents("{$scripts_source}/install.sh");
$install = replace_sql_credentials($install);
$installer = "{$scripts_destination}/" . next_id("install-{$config["MYSQLDATABASE"]}.sh");
file_put_contents($installer, $install) or die("Cannot write to Installer: " . $installer);

/**
 * Uninstall script
 */
$uninstall = file_get_contents("{$scripts_source}/uninstall.sql");
$uninstall = replace_sql_credentials($uninstall);
$uninstaller = "{$scripts_destination}/" . next_id("uninstall-{$config["MYSQLDATABASE"]}.sql");
file_put_contents($uninstaller, $uninstall) or die("Cannot write to {$uninstaller}: " . $uninstall);

$post_install = file_get_contents("{$scripts_source}/post-install.sql");
#$post_install = replace_sql_credentials($post_install);
$post_installer = "{$scripts_destination}/" . next_id("post-install-{$config["MYSQLDATABASE"]}.sql");
file_put_contents($post_installer, $post_install) or die("Cannot write to {$post_installer}: " . $post_install);

# config.mysql.inc.php file
# Add the server name for [ # CASE:SERVERNAME: ]
$mysql_config_file = $backend["paths"]["__APP_PATH__"] . "/database/config.mysql.inc.php";
$mysql_config = file_get_contents($backend["paths"]["__LIBRARY_PATH__"] . "/cruder/config.mysql.inc.php"); # Read from the CRUDer
#$mysql_config = file_get_contents($mysql_config_file);
$mysql_config = preg_replace('#\[\'host\'\] = \'.*?\';#i', "['host'] = '{$config['MYSQLHOSTNAME']}';", $mysql_config);
$mysql_config = preg_replace('#\[\'dbuser\'\] = \'.*?\';#i', "['dbuser'] = '{$config['MYSQLUSERNAME']}';", $mysql_config);
$mysql_config = preg_replace('#\[\'dbpassword\'\] = \'.*?\';#i', "['dbpassword'] = '{$config['MYSQLPASSWORD']}';", $mysql_config);
$mysql_config = preg_replace('#\[\'database\'\] = \'.*?\';#i', "['database'] = '{$config['MYSQLDATABASE']}';", $mysql_config);
$mysql_config = preg_replace('/# CASE\:__SUBDOMAIN_NAME__\:/i', "case '{$_SERVER['SERVER_NAME']}':", $mysql_config);
$mysql_config = preg_replace('/# CASE\:SERVERNAME\:/i', "case '{$_SERVER['SERVER_NAME']}':", $mysql_config);
$mysql_config = preg_replace('/\'' . preg_quote($config['frameworkname']) . '\'/i', "'{$_SERVER['SERVER_NAME']}'", $mysql_config);

# Replace the remaining ones
$mysql_config = preg_replace("/MYSQLHOSTNAME/i", $config["MYSQLHOSTNAME"], $mysql_config);
$mysql_config = preg_replace("/MYSQLUSERNAME/i", $config["MYSQLUSERNAME"], $mysql_config);
$mysql_config = preg_replace("/MYSQLPASSWORD/i", $config["MYSQLPASSWORD"], $mysql_config);
$mysql_config = preg_replace("/MYSQLDATABASE/i", $config["MYSQLDATABASE"], $mysql_config);

file_put_contents($mysql_config_file, $mysql_config) or die("Cannot write to MySQL Configuration File: " . $mysql_config_file);


$database_ini_file = "{$scripts_destination}/{$config["MYSQLDATABASE"]}.ini";
$database_parameters = "
[DATABASE]
    HOSTNAME=\"{$config["MYSQLHOSTNAME"]}\"
    USERNAME=\"{$config["MYSQLUSERNAME"]}\"
    PASSWORD=\"{$config["MYSQLPASSWORD"]}\"
    DATABASE=\"{$config["MYSQLDATABASE"]}\"
";
file_put_contents($database_ini_file, $database_parameters) or die("Cannot write to MySQL configuration ini File: " . $database_ini_file);


/**
 * Create database backup script
 *
 * @see install.bat for alternative production
 */
#$mysql_backup = "mysqldump --routines -h{$config["MYSQLHOSTNAME"]} -u{$config["MYSQLUSERNAME"]} -p{$config["MYSQLPASSWORD"]} {$config["MYSQLDATABASE"]} > {$config["MYSQLDATABASE"]}.dmp";
#$dump_file = "{$scripts_destination}/backup-{$config["MYSQLDATABASE"]}.bat";
#file_put_contents($dump_file, $mysql_backup) or die("Cannot write to: " . $framework_file);

# Post Installation files: Not used yet

/**
 * Make sure that the location will be copy-paste-able on the client computer
 * as directly taken from the browser screen selection.
 *
 * @param string $location
 *
 * @return mixed
 */
function os_dir($location = "/tmp")
{
    $is_windows = preg_match("/windows/i", $_SERVER["HTTP_USER_AGENT"], $data);
    $directory_separator = ($is_windows) ? "\\" : "/";

    return str_replace("/", $directory_separator, $location);
}

# Locate the installation directory
$install = !preg_match("#/install/#", $_SERVER["REQUEST_URI"]) ? "install/" : "";
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Framework installation process</title>

    <?php echo " <!-- "; ?>
    <link href="install.css" rel="stylesheet" type="text/css"/>
    <?php echo " --> "; ?>

    <link href="<?php echo $install; ?>install.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrapper">
    <h2>Step #1: Database and configurations</h2>

    <p>Using the <strong>root</strong> account in MySQL|MariaDB Server, hit the following Query:</p>

    <div>
<pre>
# mysql -uroot -p****

DROP DATABASE IF EXISTS `<?php echo $config["MYSQLDATABASE"]; ?>`;
CREATE DATABASE `<?php echo $config["MYSQLDATABASE"]; ?>` CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON `<?php echo $config["MYSQLDATABASE"]; ?>`.* TO "<?php echo $config["MYSQLUSERNAME"]; ?>"@"<?php echo $config["MYSQLHOSTNAME"]; ?>" IDENTIFIED BY "<?php echo $config["MYSQLPASSWORD"]; ?>";
FLUSH PRIVILEGES;
</pre>
    </div>

    <p><strong>Caution</strong>: It has been <strong class="error">replaced automatically</strong> for the first time.</p>

    <h2>Step #2: Create table structures and import the sample data</h2>
    <ol>
        <li>Add MySQL's <em>bin</em> directory to your
            <strong>system path</strong>. This means, from anywhere, your MySQL client files should be accessible. If
            you have done this, just skip this step. Press
            <strong>Windows key + Pause </strong>together (for my computer =&gt; properties). Go to
            <strong>Advanced</strong> tab. Click on <strong>Environment Variables</strong>. Add/append
            <em>bin</em> directory of your MySQL into
            <strong>PATH</strong>. eg. c:\xampp\mysql\bin. If some value is already in the path, you may have to use a
            semicolon ( ; ) to append a new path in the list.
        </li>
        <li>Execute the file
            <strong><em>database/<?php echo $config["MYSQLDATABASE"]; ?>/install-<?php echo $config["MYSQLDATABASE"]; ?>.bat</em></strong>
            produced. Run it - that it
            completes the installation. It imports all the table structures and necessary data into your MySQL database.
        </li>
        <li>Optionally execute the query:
            <em>INSERT INTO `<?php echo $config["MYSQLDATABASE"]; ?>`.`query_subdomains`(`alias_id`,`is_active`,
                subdomain_name) VALUES ("27","Y", "localhost");</em>
        </li>
        <li>Navigate to the database
            <em><strong><?php echo $config["MYSQLDATABASE"]; ?></strong></em> - and open the table
            <strong>query_users</strong>. Insert any username/password there. The password is in a clean text, without
            encryption.
        </li>
        <li><strong>Productivity Hints</strong>: Quickly
            <em>revise the list of tables and their structures</em>. Try to understand their relationships.
        </li>
    </ol>
    <p><strong class="error">Notes</strong>: For automatic installation, run</p>
    <ol>
        <li>
            <em><?php echo os_dir("install/sql-scripts/install-" . $config["MYSQLDATABASE"] . ".bat"); ?></em> (for
            newly created databases, from above)
        </li>
    </ol>
    <h2>Step #4: Modify your [ hosts ] file</h2>

    <p>Locate and edit your
        <strong>hosts</strong> file. Your test domain should point to your local machine, until you deploy. Your default
        server name should be:
        <em><?php echo $config["frameworkname"]; ?></em>.</p>
    <ol type="1">
        <li>On Windows: &quot;<em>notepad %WINDIR%\system32\drivers\etc\<strong>hosts</strong></em>&quot;</li>
        <li>On Linux: &quot;<em>vi <strong>/etc/hosts</strong></em>"</li>
        <li>Notes: structure of hosts file are different in Linux and Windows.</li>
        <li><em class="error">Hints</em>: Use
            <strong>edit-hosts-file.lnk</strong> shortcut to open the hosts file in notepad <em>(in Windows only)</em>.
        </li>
        <li>Set a <strong>default</strong> framework subdomain: <a
                href="http://127.0.0.1/"><?php echo $config["frameworkname"]; ?></a> to <a
                href="http://<?php echo $config["frameworkname"]; ?>/">127.0.0.1</a>.
        </li>
        <li>Flush your DNS Cache (<em>ipconfig /flushdns</em>). <em class="error">Hints</em>: Use
            <strong>flush.bat</strong> in the root.
        </li>
    </ol>
    <p><strong class="error">Alternatively</strong>, edit
        <em><?php echo os_dir("library/inc/inc.config.php"); ?></em> file for $_SERVER["SERVER_NAME"] of your choice.
    </p>

    <h2>Step #5: Validate the installation</h2>

    <p>Rename or copy <strong>install/license.sample</strong> to
        <strong>license.txt</strong> to validate your installation. This file is for future reference only. It is
        referred in the top of
        <em>index.php</em> file.</p>

    <p>Then, browse: <a
            href="http://<?php echo $config["frameworkname"]; ?>/">http://<?php echo $config["frameworkname"]; ?>/</a>
        locally. If you see something but the error, you are done.
    </p>

    <h2>Step #6: Allow file permissions (chmod)</h2>

    <p>The below directories need a full access, right after you install this framework.</p>

    <p>For producing the MySQL table structures by the admin.</p>

    <p><em>chmod -R 777 install/sql-scripts/</em></p>

    <p>For system operation. Includes smarty compiles, caches, menus and temporary working zones.</p>

    <!-- @todo Examples from separate file -->
    <p><em>chmod -R 777 tmp/</em></p>

    <h1>Click <a href="<?php echo ($install) ? './' : '../'; ?>"
                 style="color:#FF0000;">here to reload</a>, if completed.</h1>

    <h3>Finished! Happy coding!! Now extend it!!!</h3>

    <h2>Adding programming pages, coding for new subdomains?</h2>

    <h2>Ask for a support</h2>

    <p>Please <a
            href="https://goo.gl/WnpFxB">let us know if you need an installation support</a> and running this framework.
        Installation support is free. To use this framework for business use and make commercial applications.
    </p>

    <h1>Uninstallation</h1>
    <code>
        -- DROP DATABASE IF EXISTS `<?php echo $config["MYSQLDATABASE"]; ?>`;
        -- DROP USER "<strong><?php echo $config["MYSQLUSERNAME"]; ?></strong>"@"<strong><?php echo $config["MYSQLHOSTNAME"]; ?></strong>";
    </code>

    <h1>Important notices on:</h1>

    <h2>database tables</h2>

    <p>
        <strong>query_subdomains</strong>: List of your subdomains and main domains. There is a difference between www
        and non-www version of a subdomain. For example,
        <strong>example.com</strong> and <em
            class="error"><strong>www.</strong></em><strong>example.com</strong> should be either registered
        differently, or use Alias ID. The www and non-www versions make to different websites, because their full names
        differ. If you create an Alias ID, you make a minor website jump to the major one. Minor website should not
        contain any pages, to avoid confusions in long term.
    </p>

    <p>
        <strong>query_pages</strong>: List of your registered pages under your subdomains. If you want a new page under
        your subdomain, register it here first.
    </p>

    <h1>Some thoughts </h1>

    <h2>)-: Audiences :-(</h2>

    <p><strong>The whole application is for <em
                class="error">advanced use only</em></strong>, and targeted to at least medium level programmers. It is
        not an end product, but a tool to enhance development of a custom coded project.
    </p>

    <p>Create as many subdomains and domains as you like.
        <strong>Make a fairly complex website in just a day</strong>!</p>

    <h2>Requirements</h2>
    <ol>
        <li><a href="http://www.php.net/">PHP 5</a> / <a href="http://www.mysql.net/">MySQL 5</a>: <a
                href="http://www.centos.org/">LAMPP</a> - <a
                href="http://www.apachefriends.org/en/xampp.html">XMAPP</a> - <a
                href="http://www.wampserver.com/en/download.php">WAMP</a> Stack
        </li>
        <li><a href="http://www.smarty.net/">Smarty</a> - The major hidden core</li>
        <li>Browsers (<a href="http://www.opera.com/">Opera</a>, <a href="http://www.mozilla.org/">Firefox</a>, <a
                href="http://www.apple.com/safari/download/">Safari</a>) with javascripts enabled
        </li>
        <li>
            <a href="http://www.phpmyadmin.net/">PHPMyAdmin</a>,
            <a href="http://www.heidisql.com/">HeidiSQL</a>,
            <a href="http://www.navicat.com/">Navicat</a>,
            <a href="http://www.webyog.com/en/">SQLYog</a>
            or some similar tool to edit the database
        </li>
        <li>
            <a href="http://tortoisesvn.net/downloads.html">Tortoise SVN</a> - Keep updated with the latest source codes
            as we release them
        </li>
        <li>
            <a href="https://git-scm.com/">GIT SCM</a>,
            <a href="https://tortoisegit.org/">TortoiseGIT</a>,
            <a href="https://github.com/">GitHub</a>
        </li>
        <li><a href="http://sourceforge.net/projects/phpmailer/">PHPMailer</a> by <a
                href="http://phpmailer.worxware.com/">Worx International Inc.</a> - Compose and send emails using SMTP
            gateway
        </li>
    </ol>
</div>
</body>
</html>
