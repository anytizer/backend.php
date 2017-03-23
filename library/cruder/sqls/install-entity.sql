-- WARNING: ALL PAGES REQUIRE EXPLICIT LOGIN BY DEFAULT
-- OTHERWISE IT MAY LEAK INFORMATION FROM THE DATABASE
-- IF YOU NEED THE PAGES NOT TO REQUIRE LOGIN, FIX THEM MANUALLY

-- Update as of 2012-08-24
-- - All entities have their front-pages disabled, and require login
-- - Data safety against possible information leakages

-- Subdomain   : __SUBDOMAIN_NAME__ (ID: __SUBDOMAIN_ID__)
-- Entity      : __ENTITY__ (__ENTITY_FULLNAME__)
-- Produced on : __TIMESTAMP__

SET @SUBDOMAIN_ID = __SUBDOMAIN_ID__;

-- __COUNTER__. __ENTITY__.php
-- Non-Admin page, for visitng the site.
-- This page DOES NOT REUIQRE a login. It is sed for front-end purpose only.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__.php', '__ENTITY_FULLNAME__', '__TEMPLATE__/list-public.php',
	'List of __ENTITY_FULLNAME__', '<p>Below is a list of <!-- PLURAL? --> __ENTITY_FULLNAME__.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-blockaction.php
-- This is a controller only page to operate certain actions on a set of some records.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, is_error, needs_login, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-blockaction.php', 'Block action performed', "",
	'Block action!', '<p>This is a controller only page to perform certain actions on selected records.</p>',
	'null.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-direct-access-error.php
-- When some parameter verification failed, show this page as an error.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_error, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'N', 'Y', 'Y', 'Y',
	'__ENTITY__-direct-access-error.php', 'Error (contents protected)', "",
	'Direct access error!', '<p>Missing sufficient parameters to load the page contents. Unfortunately, direct access to this record is NOT allowed.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-search.php
-- Searching results page.
-- This page may or may not require login. Default is: login required.
-- It is used for both front end and back end purposes. Default is backend.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-search.php', 'Searching for __ENTITY_FULLNAME__', '__TEMPLATE__/list.php',
	'Searching __ENTITY_FULLNAME__', '<p>Searching is not implemented correctly. Please consider it.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-search-public.php
-- Searching results page.
-- This page may or may not require login. Default is: login required.
-- It is used for both front end and back end purposes. Default is backend.
-- Needs login as of 2012-08-24
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, is_admin, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-search-public.php', 'Search results for __ENTITY_FULLNAME__', '__TEMPLATE__/list-public.php',
	'Searching __ENTITY_FULLNAME__', '<p>We found the below results under your search criteria.</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-details-public.php
-- This page does not require a login and is for front end purpose.
-- Needs login as of 2012-08-24
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-details-public.php', 'Details of [ __ENTITY__ : __TABLE__  ] data', '__TEMPLATE__/details-public.php',
	'Details of __ENTITY_FULLNAME__', '<p><!-- PUBLIC -->Details of [ __ENTITY_FULLNAME__ ]</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __SINGULAR__.php
-- Alias of __ENTITY__-details-public.php
-- @todo Indexing Error: Duplicate entry '00-___' for key 'subdomain_page_name_unique_index'
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__SINGULAR__.php', 'Details of [ __ENTITY__ : __TABLE__  ] data', '__TEMPLATE__/details-public.php',
	'Details of __ENTITY_FULLNAME__', '<p><!-- PUBLIC -->Details of [ __ENTITY_FULLNAME__ ]</p>',
	'frontend.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-list.php
-- Backend purpose listing of entities.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	is_admin, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-list.php', 'Listing [ __ENTITY__ : __TABLE__  ] data', '__TEMPLATE__/list.php',
	'Listing __ENTITY_FULLNAME__', '<p>List of <!-- PLURAL: [ __ENTITY__ : __TABLE__ ]--> __ENTITY_FULLNAME__.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-sort.php
-- Adjusting sink_weight flag to sort the records.
-- Linked by __ENTITY__-list.php page only.
-- This is a controller-only file that redirects to listing page again.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y',
	'__ENTITY__-sort.php', 'Sorting __ENTITY__', "",
	'Sorting __ENTITY__', '<p>This is a controller only page.</p><p>We have just sorted the records in <strong>__ENTITY_FULLNAME__</strong> based on their sinking weight.</p>',
	'null.php '
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-add.php
-- Add records in [ __ENTITY__ ] table.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	is_admin, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-add.php', 'Adding a record in [ __ENTITY_FULLNAME__ ]', '__TEMPLATE__/add.php',
	'Adding __ENTITY_FULLNAME__', '<p>Please fill up the form below and click on [ Add ] button to save it.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-add-successful.php
-- When successful, it gives a link back to view the list of records
-- Needs login as of 2012-08-24
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-add-successful.php', 'Addition Successful', "",
	'Congrats!', '<p>This record is added successfully. <a href="__ENTITY__-list.php">Go back now</a> or <a href="__ENTITY__-add.php">add another record</a>.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-add-error.php
-- Needs login as of 2012-08-24
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_error, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-add-error.php', 'Addition Failed', "",
	'Sorry!', '<p>Could not save this record. Have you entered the data correctly? Any duplicates? Also check, if you passed <strong>protection code</strong> correctly. <a href="__ENTITY__-add.php">Retry</a>.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-details.php
-- Needs login as of 2012-08-24
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	is_admin, needs_login, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-details.php', 'Details of a record', '__TEMPLATE__/details.php',
	'__ENTITY_FULLNAME__', '<p>A detailed record about __ENTITY_FULLNAME__.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-edit.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, allow_edit, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-edit.php', 'Edit __ENTITY_FULLNAME__', '__TEMPLATE__/edit.php',
	'Editing __ENTITY_FULLNAME__', '<p>Please modify the below data and save it.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-edit-successful.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-edit-successful.php', 'Edit Successful', "",
	'Edit successful!', '<p>This record is modified successfully. <a href="__ENTITY__-list.php">Go back now</a>.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. __ENTITY__-edit-error.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_error, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-edit-error.php', 'Error', "",
	'Edit failed!', '<p>Error found while modifying the record. Please check for <strong>sufficient parameters</strong> and <strong>modification code</strong>.</p><p>This error also appears <strong>when you did not really edit any data</strong> but clicked on save/edit button. Or, the <strong>UPDATE</strong> query is wrong.</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-flag.php
-- This is probably a controller only page.
-- It should immediately redirect to the listing page.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-flag.php', 'Flagging [ __ENTITY__ : __TABLE__ ] data', "",
	'Flagging [ __ENTITY__ : __TABLE__ ] data', '<p>This is a controller only page to revert the current flag of the record.</p>',
	'null.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-delete.php
-- This is probably a controller only page.
-- It should immediately redirect to the success or fail page.
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-delete.php', 'Delete [ __ENTITY__ : __TABLE__ ] data', "",
	'Deleting [ __ENTITY__ : __TABLE__ ] data', '<p>This is a controller only page. Attempting to delete a record.</p>',
	'null.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-delete-successful.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-delete-successful.php', 'Deletion successful', "",
	'Record deleted successfully!', '<p>The record has been removed from the list successfully. You may think of <strong>pruning</strong> the database:table([ __ENTITY__ : __TABLE__ ]) as well. <a href="__ENTITY__-list.php">Go back now.</a></p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. controllers/__ENTITY__-delete-error.php
INSERT IGNORE INTO query_pages (
	subdomain_id, added_on,
	in_sitemap, is_error, needs_login, is_admin, is_active, is_approved,
	page_name, page_title, include_file,
	content_title, content_text,
	template_file
) VALUES (
	@SUBDOMAIN_ID, CURRENT_TIMESTAMP(),
	'N', 'Y', 'Y', 'Y', 'Y', 'Y',
	'__ENTITY__-delete-error.php', 'Deletion Failed', "",
	'Deletion failed!', '<p>The record is not deleted! Do you have enough <strong>permissions</strong> or <strong>valid code</strong> to delete this record?</p>',
	'admin.php'
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();

-- __COUNTER__. Identifiers for dropdowns usages
INSERT IGNORE INTO query_identifiers (
	subdomain_id, identifier_context, identifier_code, identifier_name,
	identifier_sql, identifier_comments,
	is_active, added_on
) VALUES (
	@SUBDOMAIN_ID, 'identifiers:__ENTITY__', 'identifiers:__ENTITY__', 'identifiers:__ENTITY__', 'SELECT
	__PK_NAME__ k,
	__SINGULAR___name v
FROM __TABLE__
WHERE
	is_active=\'Y\'
	AND is_approved=\'Y\'
	-- subdomain_id=__SUBDOMAIN_ID__
;', 'SELECT
	__PK_NAME__ k,
	__SINGULAR___name v
FROM __TABLE__
WHERE
	is_active=\'Y\'
	AND is_approved=\'Y\'
	-- AND subdomain_id=__SUBDOMAIN_ID__
;', 'Y', CURRENT_TIMESTAMP()
) ON DUPLICATE KEY UPDATE fixed_on = CURRENT_TIMESTAMP();
