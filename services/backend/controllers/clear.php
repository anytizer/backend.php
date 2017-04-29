<?php


# This file can be refered by any subdomain service
# and browsed as http://<subdomain>/clear.php

# Updates the number of pages counter in each subdomains.
$subdomains = new \subdomain\subdomains();
$subdomains->update_pages_counter();

# Warning: Keep valid SQLs only, just enough to clean up the system
$sqls = array();
$sqls[] = 'TRUNCATE `query_logger`;';

# May force to logout a user immediately.
# Selective removal added.
$sqls[] = 'TRUNCATE `query_sessions`;';

$sqls[] = 'TRUNCATE `query_errors`;';

# statistical resetting - may be unsafe, when you need them.
#$sqls[] = 'UPDATE query_pages SET page_counter=0, accessed_on=0;';
#$sqls[] = 'UPDATE query_uploads SET downloads_counter=0;';

# Unsafe Queries
#############################################################

# If you do not need
# $sqls[] = 'TRUNCATE `breaking_news`;';

# Only on a very NEW installation, where you have to define everything.
# $sqls[] = 'TRUNCATE `query_emails`;';


# old session data
#############################################################

# To delete the empty sessions
$sqls[] = 'DELETE FROM query_sessions WHERE session_data = \'\';';

# Delete too old session entries
$sqls[] = 'DELETE FROM query_sessions WHERE added_on <= UNIX_TIMESTAMP(DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 24 HOUR));';


# Re-indexing and performance turning SQLs
#############################################################
# These queries should not be loaded too frequently.
# Once in a month is okay, or right after the first installation.

# Subdomain names
$sqls[] = 'ALTER TABLE `query_subdomains` DROP KEY `subdomain_name_unique_index`;';
$sqls[] = 'ALTER TABLE `query_subdomains` ADD UNIQUE KEY `subdomain_name_unique_index` (`subdomain_name`);';

# Remake the key for Subdomain ID and page name.
$sqls[] = 'ALTER TABLE `query_pages` DROP KEY `subdomain_page_name_unique_index`;';
$sqls[] = 'ALTER TABLE `query_pages` ADD UNIQUE KEY `subdomain_page_name_unique_index` (`subdomain_id`,`page_name`);';

# Menu contexts
$sqls[] = 'ALTER TABLE `query_menus` DROP KEY `menu_context_index`;';
$sqls[] = 'ALTER TABLE `query_menus` ADD KEY `menu_context_index` (`menu_context`, `sink_weight`);';

# Code contexts
$sqls[] = 'ALTER TABLE `query_code_generators` DROP KEY `code_context_code_name_unique_index`;';
$sqls[] = 'ALTER TABLE `query_code_generators` ADD UNIQUE KEY `code_context_code_name_unique_index` (`code_context`,`code_name`);';

# Defined constants
$sqls[] = 'ALTER TABLE `query_defines` DROP KEY `subdomain_id_define_name_unique_index`;';
$sqls[] = 'ALTER TABLE `query_defines` ADD UNIQUE KEY `subdomain_id_define_name_unique_index` (`subdomain_id`,`define_name`);';

# Drop down menus
$sqls[] = 'ALTER TABLE `query_dropdowns` DROP KEY `dropdown_parent_id_index`;';
$sqls[] = 'ALTER TABLE `query_dropdowns` ADD KEY `dropdown_parent_id_index` (`parent_id`);';

# Email templates
$sqls[] = 'ALTER TABLE `query_emails` DROP KEY `email_code_unique_index`;';
$sqls[] = 'ALTER TABLE `query_emails` ADD UNIQUE KEY `email_code_unique_index` (`email_code`);';

# SMTP Accounts
$sqls[] = 'ALTER TABLE `query_emails_smtp` DROP KEY `smtp_identifier_unique_index`;';
$sqls[] = 'ALTER TABLE `query_emails_smtp` ADD UNIQUE KEY `smtp_identifier_unique_index` (`smtp_identifier`);';

# Identifiers - as used in dropdowns lists
$sqls[] = 'ALTER TABLE `query_identifiers` DROP KEY `subdomain_id_identifier_code_unique_index`;';
$sqls[] = 'ALTER TABLE `query_identifiers` ADD UNIQUE KEY `subdomain_id_identifier_code_unique_index` (`subdomain_id`,`identifier_code`);';

# Users database
$sqls[] = 'ALTER TABLE `query_users` DROP KEY `user_name_unique_index`;';
$sqls[] = 'ALTER TABLE `query_users` ADD UNIQUE KEY `user_name_unique_index` (`user_name`);';

# List of table names
$sqls[] = 'ALTER TABLE `query_tables` DROP KEY `table_name_unique_key`;';
$sqls[] = 'ALTER TABLE `query_tables` ADD UNIQUE KEY `table_name_unique_key` (`table_name`);';

# List of files uploaded on the server
$sqls[] = 'ALTER TABLE `query_uploads` DROP KEY `file_code_unique_index`;';
$sqls[] = 'ALTER TABLE `query_uploads` ADD UNIQUE KEY `file_code_unique_index` (`file_code`);';

/**
 * Cleans up the database
 */
foreach ($sqls as $s => $sql) {
    # Only after specified period of last execution, excetute this.
    # Otherwise, not necessary to rebuild the indices so often.
    #$db->query($sql);
}

/**
 * Cleans up the Smarty's compiled pages.
 * Sometimes, FTP can not delete the smarty compiled files.
 * This script removes them all.
 */

# This block runs selectively in another operation. Do not use this block
# and prevent other files.

/*
# Clear compiled files, with their IDs
$sql='SELECT subdomain_name subdomain FROM query_subdomains GROUP BY subdomain_name;';
$db->query($sql);
while($row = $db->row(""))
{
	$smarty->compile_id = preg_replace('/[^a-z]/is', "", $row['subdomain']);
	$smarty->utility->clearCompiledTemplate(null, $smarty->compile_id);
	#$smarty->utility->clearCompiledTemplate(); # Removes everything
	$smarty->utility->clearCache()
}
*/

/**
 * Cleanup these directories that contain .php cachec files.
 */
$dirs = array(
    'sessions', # File based session data: It may immediately logout a user
    'smarty_cache', # Smarty's caches
    'smarty_compiles', # Smarty's compiled output - for all registered subdomains
    'sqls', # Chronoligical log of SQLs operated
    'superfish', # SuperFish menus for jQuery plugin
    #'to_javascript', # Externalized javascripts
);

foreach ($dirs as $d => $dir) {
    /**
     * @todo Check if useful
     */
    $dir = __TEMP_PATH__ . '/' . $dir;
    if (is_dir($dir) && $handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            # .php : plain html/php generated within the loops.
            # .cok : Cookies for cURL
            # .js  : Extenalized javascripts, using Smarty's block
            # .log : Logs, Database Queries
            # .serialised : PHP Variables, to build dropdown lists of links.* pages.
            # sess_: PHP session data files
            if (preg_match('/\.(php|cok|js|log|serialized)$/', $file) || preg_match('/^sess_[a-z0-9]{32}$/', $file)) {
                # Deletes only specified extensions
                # Removes PHP Sessions, if any
                unlink("{$dir}/{$file}");
                #echo "\r\n{$dir}/{$file}";
            }
        }
        closedir($handle);
    }
}

/**
 * Everything is finished clearing.
 * Go to the information page now, which will lead to the home page again.
 */
\common\stopper::url('cache-cleared.php');

