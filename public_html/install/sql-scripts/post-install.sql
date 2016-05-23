-- Run these commands after completing your installation.

-- Empty the session logs
TRUNCATE query_sessions;

-- @todo Import the valid new passwords instead of random strings
-- Protect the existing user accounts
TRUNCATE query_users;

-- Add a new user: admin/password
INSERT INTO `query_users`(
	`added_on`,
	`full_name`, `user_name`, `user_password`,
	`is_active`, `is_approved`, `is_admin`, `do_export`
) VALUES (
	CURRENT_TIMESTAMP(),
	'Administrator', 'admin', 'uS+8ZT1q0Q/+9aISb7dD1Qvtx7COI868uJPmmrAFY5c=',
	'Y', 'Y', 'Y', 'Y'
);

-- @todo Column types should change to datetime
-- Make 'localhost' act as backend for first welcome
INSERT INTO `query_subdomains`(
`alias_id`,`status_id`,`begun_on`,`added_on`,`fixed_on`,`modified_on`,`modified_counter`,`installed_on`,`shutdown_on`,`live_on`,`sink_weight`,`subdomain_port`,`pages_counter`,`is_active`,`is_approved`,`is_installed`,`is_protected`,`is_hidden`,`is_system`,`is_down`,`is_https`,`is_www`,`is_live`,`is_merged`,`db_templates`,`template_file`,`subdomain_key`,`subdomain_prefix`,`subdomain_name`,`subdomain_short`,`subdomain_comments`,`subdomanin_theme`,`dir_controllers`,`dir_templates`,`dir_configs`,`dir_plugins`,`subdomain_url`,`subdomain_url_local`,`subdomain_ip`,`pointed_to`,`ftp_host`,`ftp_username`,`ftp_password`,`ftp_path`,`db_host`,`db_usename`,`db_password`,`db_database`,`finger_link`,`finger_hash`,`subdomain_description`
) VALUES (
'27','0','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0','80','0','Y','Y','Y','N','N','N','N','N','N','N','N','N','','','','localhost','','','','controllers','templates','configs','plugins','','','0.0.0.0','','','','','/','','','','','','',''
);