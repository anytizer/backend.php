# Subdomain   : __SUBDOMAIN_NAME__ (id: __SUBDOMAIN_ID__))
# Entity      : __ENTITY__
# Produced on : __TIMESTAMP__

SET @SUBDOMAIN_ID = __SUBDOMAIN_ID__;

# @todo Fix required
# __COUNTER__. robots.txt
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'robots.txt', 'robots.txt', "",
	'robots.txt', 'robots.txt',
	'null.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. cron.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'cron.php', 'Cron', "",
	'Cron Output', 'Cron Page',
	'null.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. index.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'index.php', 'Welcome', 'includes/login.php',
	'Welcome', '<p>Please <a href="login.php">login</a> to continue.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. login.php
# Allow for all guests
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'login.php', 'Admin Login', 'includes/login.php',
	'Login', '<p>Please login to __SUBDOMAIN_NAME__.</p>',
	'login.php' # This is a full page in itself
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. admin.php
# Allow for all guests
# Alias of login.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'admin.php', 'Admin Login', "",
	'Login', '<p>Please login to __SUBDOMAIN_NAME__.</p>',
	'login.php' # This is a full page in itself
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. login-failed.php
# Allow for all users who failed to login successfully
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'login-failed.php', 'Login failed', 'includes/login.php',
	'Login Failed', '<p><strong>Sorry</strong>, but your login failed. Please type your username and password correctly.</p>\r\n<p>What do you want to do now?</p>\r\n<p><a href="login.php">Retry login</a> or <a href="./">Cancel</a>.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. logout.php
# Allow only for logged in users
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'N', 'Y', 'Y',
	'logout.php', 'Logout', "",
	'Logout', '<p>Logging you out from __SUBDOMAIN_NAME__.<p>',
	'null.php' # This is a full page
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. dashboard.php
# Allow for all guests
# Alias of login.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y',
	'dashboard.php', 'Admin Dashboard', "",
	'Dashboard', '<p>Welcome to administrative dashboard. Please operate carefully.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. password-forgot.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'password-forgot.php', 'Reset your password', 'password/forgot.php',
	'Forgot password?', '<p>Did you forget your password? Please enter your usename or email address. Then we will send you a link to reset your password.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. password-change.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'N', 'Y', 'Y',
	'password-change.php', 'Change your password now', 'password/change.php',
	'Change password?', '<p>Hints: For your safety reasons, please change your password frequently.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. password-changed-successfully.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'N', 'Y', 'Y',
	'password-changed-successfully.php', 'Your password has been changed successfully.', "",
	'Password changed', '<p>Your password has been changed successfully.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. password-change-failed.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'N', 'Y', 'Y',
	'password-change-failed.php', 'Your password is not changed.', "",
	'Password was NOT changed', '<p>sorry, but we encountered a problem while changing your password. Please attempt with valid old password and new passwords.</p><p>There can be several reasons why password change failed.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. sitemap.php
# Optionally limit to logged in users
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y', # Are you sure?
	'sitemap.php', 'Sitemap of public pages', 'sitemap/sitemap.php',
	'Sitemap', '<p>Below is a list of all sitemap links.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. about-us.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'about-us.php', 'About us',
	'About us', '<p>We have used <a href="https://goo.gl/WnpFxB">Backend Framework</a> to make this website. Please use <a href="cms-list.php">CMS page editor</a> to modify the contents.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. contact-us.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'contact-us.php', 'Contact us', 'includes/contact-us.php',
	'Send us an email', '<p>Please fill-up the form below to send us an email.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. permission-denied.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'permission-denied.php', 'Access error', "",
	'Permission denied', '<p>You do not have sufficient authority to access this page.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. 404.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y',
	'404.php', '404 Error',
	'Page does not exist.', '<p>We were unable to find your requested file.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. reports.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	needs_login, is_admin, is_active, is_approved,
	page_name, page_title,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y',
	'reports.php', 'Reports',
	'Reports', '<p>Reports are not implemented.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

# __COUNTER__. captcha.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	is_active, is_approved, is_system, is_admin, is_generic, is_featured, needs_login, is_error, in_sitemap, allow_edit,
	page_name, page_title, include_file, content_title, content_text,
	meta_keywords, meta_description, template_file, page_comments, page_extra
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N',
	'captcha.php', 'Captcha Image', "", 'Captcha Image', "",
	"", "", 'null.php', "", ""
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();
