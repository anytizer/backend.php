/**
* Skeleton of [Query Articles: query_articles]
* Dynamic article pieces
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_articles` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Article ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Who wrote this article?',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on: first time created date',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'How many times is this record modified?',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active record?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Did we approve this record?',
  `is_html` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Should we support HTML tags?',
  `article_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'Some Code',
  `article_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Box text title',
  `article_xref` varchar(255) NOT NULL DEFAULT '' COMMENT 'Additional XREF if used',
  `article_image` varchar(255) NOT NULL DEFAULT '' COMMENT 'Associated image file',
  `article_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Short comments',
  `article_excerpt` text NOT NULL COMMENT 'Summary of the article',
  `article_text` text NOT NULL COMMENT 'Main, full text contents',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dynamic article pieces';

/**
* Skeleton of [Query Cdn: query_cdn]
* Distributes CDN(Content Distribution Network) links
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_cdn` (
  `cdn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Content Distribution Network Link ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'First time added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active link?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved CDN?',
  `cdn_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Full name of the content in CDN',
  `cdn_mime` varchar(255) NOT NULL DEFAULT '' COMMENT 'MIME for this CDN content',
  `cdn_local_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'When using local links or internet is not available',
  `cdn_remote_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Live links to the content',
  `cdn_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Comments to the link',
  `cdn_version` varchar(255) NOT NULL DEFAULT '' COMMENT 'Latest available version number, if applies',
  PRIMARY KEY (`cdn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Distributes CDN(Content Distribution Network) links';

/**
* Skeleton of [Query Code Generators: query_code_generators]
* Code Generator - Standard Framework
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_code_generators` (
  `code_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Code Generator ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved record?',
  `is_year` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Use YEAR portion?',
  `code_context` varchar(50) NOT NULL DEFAULT '' COMMENT 'Collective name of the context, /[a-z]/',
  `code_name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Unique calling name under a context, /[a-z]/',
  `code_prefix` varchar(255) NOT NULL DEFAULT '' COMMENT 'Prepend this',
  `code_mask` varchar(255) NOT NULL DEFAULT 'X' COMMENT 'Mask with this text',
  `code_length` int(10) unsigned NOT NULL DEFAULT '5' COMMENT 'Masking length',
  `code_value` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Running code value',
  `code_year` year(4) NOT NULL DEFAULT '0000' COMMENT 'Year, if dependent',
  `code_suffix` varchar(255) NOT NULL DEFAULT '' COMMENT 'Prepend this',
  `code_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Why?',
  `code_meta1` varchar(255) NOT NULL DEFAULT '' COMMENT 'Additional information',
  `code_meta2` varchar(255) NOT NULL DEFAULT '' COMMENT 'Additional information',
  `code_meta3` varchar(255) NOT NULL DEFAULT '' COMMENT 'Additional information',
  `code_meta` varchar(255) NOT NULL DEFAULT '' COMMENT 'Additional information on meta data',
  PRIMARY KEY (`code_id`),
  UNIQUE KEY `code_context_code_name_unique_index` (`code_context`,`code_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Code Generator - Standard Framework';

/**
* Skeleton of [Query Config: query_config]
* Standard configurations used in the subdomains
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Configuration ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active configuration?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved configuration?',
  `is_editable` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Include in editor?',
  `config_context` varchar(255) NOT NULL DEFAULT '' COMMENT 'Sitewide context',
  `config_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Identifier',
  `config_value` varchar(255) NOT NULL DEFAULT '' COMMENT 'Value',
  `config_type` varchar(255) NOT NULL DEFAULT '' COMMENT 'Storage Type',
  `config_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Explanation',
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `query_config_subdomain_id_config_name_index` (`subdomain_id`,`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Standard configurations used in the subdomains';

/**
* Skeleton of [Query Contacts: query_contacts]
* Contact Us data received by the front end contact us forms
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_contacts` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Contact ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Record added on (first entry)',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `replied_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When was it replied back',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Record last modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `read_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of opening the message',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting controller, heavier objects sink deep',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active record? (Not yet deleted permanently)',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Suspendable, logically active record, if applies',
  `is_read` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Did we read this contact?',
  `is_replied` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Did the admin reply to this email',
  `contact_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Who is contacting the admin',
  `contact_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Email address of the contactor',
  `contact_subject` varchar(255) NOT NULL DEFAULT '' COMMENT 'Subject of the message',
  `contact_message` text NOT NULL COMMENT 'Full plain/text email message',
  `contact_ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP address in number format',
  `contact_host` varchar(255) NOT NULL DEFAULT '' COMMENT 'Host name of the current IP address',
  `contact_browser` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTTP user agent',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contact Us data received by the front end contact us forms';

/**
* Skeleton of [Query Cruded: query_cruded]
* Record of cruded classes and services
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_cruded` (
  `crud_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'CRUD ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `cruded_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When CRUDed?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `uninstalled_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Removed On - 0 = New, Timestamp = Uninstalled on',
  `is_uninstalled` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Removed this CRUDed entity?',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active entity? Defaults to Yes - Y',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved record?',
  `full_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Full and readable name of this CRUD entity',
  `crud_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'CRUD Entity Name',
  `protection_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'Protection code that was generated for this entity',
  `table_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Which table is it refering to?',
  `pk_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Primary Key Name (Column) in this table',
  `written_to` varchar(255) NOT NULL DEFAULT '' COMMENT 'Where were the CRUD base files exported to?',
  PRIMARY KEY (`crud_id`),
  UNIQUE KEY `subdomain_id_crud_name_index` (`subdomain_id`,`crud_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Record of cruded classes and services';

/**
* Skeleton of [Query Defines: query_defines]
* PHP Constants defined here per subdomain
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_defines` (
  `define_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Defined Constant ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'First time added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight, not useful here',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Load this defined context?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved constant name?',
  `is_global` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Load this for ALL subdomains?',
  `auto_load` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Autoload this value?',
  `allow_edit` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'On leased systems; allow editors modify this value?',
  `define_context` varchar(255) NOT NULL DEFAULT 'config' COMMENT 'config = System defined context for logical grouping of configurations',
  `define_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Define Name, the CONSTANT name (upper case with underscores preferred)',
  `define_value` varchar(255) NOT NULL DEFAULT '' COMMENT 'Defined value that it holds',
  `define_sample` varchar(255) NOT NULL DEFAULT '' COMMENT 'Copy of defined value as a sample/hint/reference',
  `define_handler` varchar(255) NOT NULL DEFAULT '' COMMENT 'PHP hanlder function to process the data',
  `define_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'What does this configuration do?',
  PRIMARY KEY (`define_id`),
  UNIQUE KEY `subdomain_id_define_name_unique_index` (`subdomain_id`,`define_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PHP Constants defined here per subdomain';

/**
* Skeleton of [Query Development History: query_development_history]
* Records of what we did while developing things
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_development_history` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'History ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active record?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved history?',
  `history_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Quick title',
  `history_text` text NOT NULL COMMENT 'Development Message',
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Records of what we did while developing things';

/**
* Skeleton of [Query Distributions: query_distributions]
* Downlodable distributions made with this framework
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_distributions` (
  `distribution_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Distribution ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When added?',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting weight',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'File size in bytes',
  `stats_comments` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Source code comments',
  `stats_html` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'HTML Size',
  `stats_php` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'PHP Size',
  `stats_js` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'JS Size',
  `stats_css` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'CSS Size',
  `stats_images` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Images Size',
  `stats_text` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Text file Size',
  `stats_templates` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Templates size',
  `stats_scripts` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '.sh, .bat, etc. scripts size',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow to download this?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved distribution?',
  `show_links` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Show links?',
  `show_samples` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Show samples?',
  `distribution_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link to this product or sample',
  `distribution_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title',
  `distribution_text` text NOT NULL COMMENT 'Description',
  PRIMARY KEY (`distribution_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Downlodable distributions made with this framework';

/**
* Skeleton of [Query Downloads: query_downloads]
* List of good products to allow downloads
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_downloads` (
  `download_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Downloadable URL ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'Show this link?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved download link?',
  `download_text` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link Text',
  `download_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'Downlaod link',
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of good products to allow downloads';

/**
* Skeleton of [Query Dropdowns: query_dropdowns]
* SQL holder to generate dropdown menus via superfish plugin
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_dropdowns` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Menu ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent Menu ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '99' COMMENT 'Ordering',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active superfish menu?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved dropdown link?',
  `menu_context` varchar(255) NOT NULL DEFAULT '' COMMENT 'Identifier',
  `menu_text` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link Name',
  `menu_link` varchar(255) NOT NULL DEFAULT '#' COMMENT 'Links to this url',
  `menu_description` text NOT NULL COMMENT 'Descriptions for reusability',
  PRIMARY KEY (`menu_id`),
  KEY `dropdown_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='SQL holder to generate dropdown menus via superfish plugin';

/**
* Skeleton of [Query Emails: query_emails]
* Email Templates Holder
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_emails` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Email Template ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active Template?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved email template?',
  `allow_edit` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow edit this email template for admin users?',
  `email_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'Unique email identifier',
  `email_language` varchar(255) NOT NULL DEFAULT 'EN' COMMENT 'Additional lanaguge (if developing language specific application)',
  `email_subject` varchar(255) NOT NULL DEFAULT '' COMMENT 'Email subject',
  `email_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Comments on this email template',
  `email_html` text NOT NULL COMMENT 'Full HTML text',
  `email_text` text NOT NULL COMMENT 'Alternative plain text',
  PRIMARY KEY (`email_id`),
  UNIQUE KEY `email_code_unique_index` (`email_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Email Templates Holder';

/**
* Skeleton of [Query Emails Smtp: query_emails_smtp]
* List of SMTP user accounts
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_emails_smtp` (
  `smtp_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'SMTP Account ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `smtp_identifier` varchar(255) NOT NULL DEFAULT '' COMMENT 'Unique Code',
  `smtp_host` varchar(255) NOT NULL DEFAULT '' COMMENT 'SMTP Server',
  `smtp_port` varchar(255) NOT NULL DEFAULT '587' COMMENT 'Port to connect, eg 25, 26, 465, 587, 2525, ...',
  `connection_prefix` varchar(255) NOT NULL DEFAULT '' COMMENT 'Empty String / TLS / SSL',
  `do_authenticate` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'Y/N - SMTP Login needs authentication',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active account?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved account?',
  `is_smtp` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'By default, SMTP account. If no, send messages as php default.',
  `smtp_username` varchar(255) NOT NULL DEFAULT '' COMMENT 'SMTP Username',
  `smtp_password` varchar(255) NOT NULL DEFAULT '' COMMENT 'SMTP Password',
  `from_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'From Name',
  `from_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'From Email',
  `replyto_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Reply To Name',
  `replyto_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Reply To Email',
  `smtp_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Notes on this login details',
  PRIMARY KEY (`smtp_id`),
  UNIQUE KEY `smtp_identifier_unique_index` (`smtp_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of SMTP user accounts';

/**
* Skeleton of [Query Errors: query_errors]
* Trapped PHP Error logs
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_errors` (
  `error_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Error ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Subdomain ID',
  `added_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Modifications counter',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active record?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved record?',
  `error_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Error happened on',
  `error_no` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Error ID',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Error in file',
  `line_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Line Number',
  `variables` text NOT NULL COMMENT 'Variables',
  `error_message` text NOT NULL COMMENT 'Error Message',
  PRIMARY KEY (`error_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Trapped PHP Error logs';
/**
* Skeleton of [Query Identifiers: query_identifiers]
* To be used by Smarty plugin: |dropdown
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_identifiers` (
  `identifier_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifier ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight, not used',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active? Flag them all to YES!',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved identifier?',
  `identifier_context` varchar(255) NOT NULL DEFAULT '' COMMENT 'Why? Group results with this context',
  `identifier_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'What to search for?',
  `identifier_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Unused, but short name',
  `identifier_sql` text NOT NULL COMMENT '`k` => `v` SQL Results',
  `identifier_comments` text NOT NULL COMMENT 'Hints, reasons or backup',
  PRIMARY KEY (`identifier_id`),
  UNIQUE KEY `subdomain_id_identifier_code_unique_index` (`subdomain_id`,`identifier_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='To be used by Smarty plugin: |dropdown';

/**
* Skeleton of [Query Licenses: query_licenses]
* Licenses generated for users
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_licenses` (
  `license_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'License ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'License added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'License modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `expires_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When will this license expire?',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `server_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Remove/Server IP who requested the license',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active license?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved license?',
  `is_valid` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Is the generated license key valid?',
  `application_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the application being licensed',
  `server_name` varchar(255) NOT NULL DEFAULT '' COMMENT '$_SERVER[SERVER_NAME] of the client''s machine: web host name there',
  `installed_on` varchar(255) NOT NULL DEFAULT '' COMMENT 'YYYYMMDDHHIISSXXXX 18 characters stamp when installed',
  `protection_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'Some random text to use in MD5 Hash Generation',
  `license_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'md5(protection_key.installed_on.server_name), unique',
  `license_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'License owner (email address)',
  `license_to` varchar(255) NOT NULL DEFAULT '' COMMENT 'License owner (full name)',
  PRIMARY KEY (`license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Licenses generated for users';

/**
* Skeleton of [Query Logger: query_logger]
* Unique visitors - browser access log
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_logger` (
  `logged_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Logger ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Useless; logged_on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Useless',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless; modified counter',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless; sink weight',
  `is_active` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless; Active log?',
  `is_approved` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless; Approved log?',
  `logged_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date/Time of log (Unix Epoch)',
  `logged_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'IPv4 to Long - numeric IP address',
  `logged_ipv6` varchar(255) NOT NULL DEFAULT '' COMMENT 'IPv6 in text format address',
  `logged_isp` varchar(255) NOT NULL DEFAULT '' COMMENT 'ISP Host Name',
  `browser_language` varchar(255) NOT NULL DEFAULT '' COMMENT 'Language',
  `browser_encoding` varchar(255) NOT NULL DEFAULT '' COMMENT 'Encoding',
  `browser_charset` varchar(255) NOT NULL DEFAULT '' COMMENT 'Character Set',
  `browser_accept` varchar(255) NOT NULL DEFAULT '' COMMENT 'Encoding Accepted',
  `browser_browser` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTTP Agent',
  `browser_profile` varchar(255) NOT NULL DEFAULT '' COMMENT 'Browser Profile',
  `profile_wap` varchar(255) NOT NULL DEFAULT '' COMMENT 'WAP Profile',
  `browser_referer` varchar(255) NOT NULL DEFAULT '' COMMENT 'Entry point referer',
  PRIMARY KEY (`logged_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Unique visitors - browser access log';

/**
* Skeleton of [Query Menus: query_menus]
* List of menus to load with {menus} plugin
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Menu ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent Menu ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '99' COMMENT 'Sorting',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Menu item removed?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved menu?',
  `show_link` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Make the link clickable or show the text only?',
  `allow_edit` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow edit this menu entry?',
  `confirm_click` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Ask a user for confirmation?',
  `menu_status` enum('O','L','A') NOT NULL DEFAULT 'O' COMMENT 'O: Logged out, L: Logged In, A: All times',
  `menu_context` varchar(255) NOT NULL DEFAULT '' COMMENT 'Menu Grouping',
  `menu_text` varchar(255) NOT NULL DEFAULT '' COMMENT 'Text to show in the menu',
  `menu_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Menu links here',
  `link_target` varchar(255) NOT NULL DEFAULT '_top' COMMENT 'Link jumps to this tagrget: _blank, _parent, _self, _top',
  `html_alt` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML Alternative Tag',
  `html_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML Title Tag',
  `html_class` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML .class for CSS/Javascript',
  `html_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML #ID for CSS/Javascript',
  `menus_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Any extra notes',
  PRIMARY KEY (`menu_id`),
  KEY `menu_context_index` (`menu_context`,`sink_weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of menus to load with {menus} plugin';

/**
* Skeleton of [Query Messages: query_messages]
* Who sent what message to whom?
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Message ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Modified counter',
  `display_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of displays',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'Active message?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved message?',
  `message_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'Unique code for this message',
  `message_status` varchar(255) NOT NULL DEFAULT '' COMMENT 'What kind of message is this? (error, success, notice, warning, info, caution)',
  `message_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Where is this messaged used in?',
  `message_body` text NOT NULL COMMENT 'Full message body',
  PRIMARY KEY (`message_id`),
  UNIQUE KEY `message_code_index` (`message_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Who sent what message to whom?';

/**
* Skeleton of [Query Pages: query_pages]
* All registered webpages for each subdomains
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Page ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting pages, eg. In sitemaps',
  `page_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Count how many times is this page served for',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date/Time of creating this page',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Page modified last time by the (sub) admin user',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Counts how many times was the page contents modified',
  `accessed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UNIX Timestamp of current page access',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'Is this page visible?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved page?',
  `is_system` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'System required file?',
  `is_admin` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow only admins to access this page?',
  `is_generic` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Page written for generic purpose?',
  `is_featured` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Reusability: Host featured articles',
  `needs_login` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'This page needs user login to access the contents',
  `is_error` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Error messages?',
  `in_sitemap` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Include in sitemap listing?',
  `allow_edit` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'If CMS customized, allow a user to edit the pages?',
  `page_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Search engine friendly URL page name',
  `page_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML Page Title - within &lt;title&gt; ... &lt;/title&gt; tag',
  `include_file` varchar(255) NOT NULL DEFAULT '' COMMENT 'Addtional HTML template file to be included',
  `content_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Contents Title (Heading)',
  `content_text` text NOT NULL COMMENT 'Static HTML Text',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML Meta Keywords',
  `meta_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'HTML Meta Description',
  `template_file` varchar(255) NOT NULL DEFAULT 'frontend.php' COMMENT 'Which template? admin.php, frontend.php, null.php, blank.php',
  `page_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Quick page comments - for developers',
  `page_extra` varchar(255) NOT NULL DEFAULT '' COMMENT 'Anything that can be used programtically, like: page banner URL',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `subdomain_page_name_unique_index` (`subdomain_id`,`page_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All registered webpages for each subdomains';

/**
* Skeleton of [Query Server: query_server]
* List of SQLs to intake as Standard Report Queires
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_server` (
  `query_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Server Query ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '99' COMMENT 'Sorting',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'Y' COMMENT 'Actively usable query?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved server query?',
  `query_identifier` varchar(255) NOT NULL DEFAULT '' COMMENT 'SQL Identifier Name, one word in upper case',
  `query_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Why we are using this?',
  `query_body` text NOT NULL COMMENT 'FULL Body of the SQL',
  PRIMARY KEY (`query_id`),
  UNIQUE KEY `identifier_index` (`query_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of SQLs to intake as Standard Report Queires';

/**
* Skeleton of [Query Sessions: query_sessions]
* Storage for database handled PHP Sessions
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_sessions` (
  `session_id` varchar(50) NOT NULL DEFAULT '' COMMENT 'PHP Session ID - String',
  `session_ip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Which IP is used to request the services?',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Session created or last modified on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Total number of modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless; sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Useless; Sink weight',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Useless; Approved session data?',
  `session_ipv6` varchar(255) NOT NULL DEFAULT '' COMMENT 'IPV6 text format address',
  `session_data` text NOT NULL COMMENT 'Session Data, keep as short as possible',
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Storage for database handled PHP Sessions';

/**
* Skeleton of [Query Subdomains: query_subdomains]
* List of all sub-domains
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_subdomains` (
  `subdomain_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Subdomain ID?',
  `alias_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Alias/Redirection ID: KEEP ZERO for most of the times',
  `status_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Current status of the project - in idea, begun, development, revision, production, obsolete',
  `begun_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Timestamp - When did the project begin?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When modified last time?',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `installed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last installed on',
  `shutdown_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When was it last shut down?',
  `live_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Re-Live on?',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sinking weight',
  `subdomain_port` int(10) unsigned NOT NULL DEFAULT '80' COMMENT 'Port on which the server is currently running on, useful in making FULL URL of the subdomain',
  `pages_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Static counter of number of active pages inside it',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active subdomain module?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved subdomain module?',
  `is_installed` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Did we install this subdomain?',
  `is_protected` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Avoid a subdomain being exported - Exporter will not see this',
  `is_hidden` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Logically hide this domain?',
  `is_system` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Does this application ship as a default module?',
  `is_down` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Is this website taken into offline mode?',
  `is_https` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Use HTTPS instead of HTTP? HTTPS is good for security.',
  `is_www` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Force using www version?',
  `is_live` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'N = Local, Y = Live, Write to hosts file as local subdomain?',
  `is_merged` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Do we own the entire data contains within this framework?',
  `db_templates` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Are the template files hosted in database?',
  `template_file` varchar(255) NOT NULL DEFAULT '' COMMENT 'management.php: Systemwide default global template file: useful to test different templates without renaming',
  `subdomain_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'Some Unique Identifier',
  `subdomain_prefix` varchar(255) NOT NULL DEFAULT '' COMMENT 'CSV Prefix on database tables and auto-generated files',
  `subdomain_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'FQDN, Complete identifying name, eg: localhost, www.subdomain.com',
  `subdomain_short` varchar(255) NOT NULL DEFAULT '' COMMENT 'Short identifiying name, used as quick identifier',
  `subdomain_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Extra comments on this subdomain name',
  `subdomanin_theme` varchar(255) NOT NULL DEFAULT '' COMMENT 'Default customized theme',
  `dir_controllers` varchar(255) NOT NULL DEFAULT 'controllers' COMMENT 'Directory: controllers - Smarty Configuration',
  `dir_templates` varchar(255) NOT NULL DEFAULT 'templates' COMMENT 'Directory: templates - Smarty configuration',
  `dir_configs` varchar(255) NOT NULL DEFAULT 'configs' COMMENT 'Directory: configs - Smarty configuration',
  `dir_plugins` varchar(255) NOT NULL DEFAULT 'plugins' COMMENT 'Directory: plugins - Smarty configuration',
  `subdomain_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'On deployment - Redirected/Full URL',
  `subdomain_url_local` varchar(255) NOT NULL DEFAULT '' COMMENT 'Local (test server URL)',
  `subdomain_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0' COMMENT 'Static IP Address of the server where this subdomain is deployed on',
  `pointed_to` varchar(255) NOT NULL DEFAULT '' COMMENT '__BASE__: Where is this domain pointed physically on the LOCAL?',
  `ftp_host` varchar(255) NOT NULL DEFAULT '' COMMENT 'FTP Host Name on remote server',
  `ftp_username` varchar(255) NOT NULL DEFAULT '' COMMENT 'FTP User Name on remote server',
  `ftp_password` varchar(255) NOT NULL DEFAULT '' COMMENT 'FTP Password on remote server',
  `ftp_path` varchar(255) NOT NULL DEFAULT '/' COMMENT 'FTP path from where this application will work on',
  `db_host` varchar(255) NOT NULL DEFAULT '' COMMENT 'Database host',
  `db_usename` varchar(255) NOT NULL DEFAULT '' COMMENT 'Database username',
  `db_password` varchar(255) NOT NULL DEFAULT '' COMMENT 'Database password',
  `db_database` varchar(255) NOT NULL DEFAULT '' COMMENT 'Database name',
  `finger_link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link to a simple text file, which monitors the subdomain',
  `finger_hash` varchar(255) NOT NULL DEFAULT '' COMMENT 'Hash of finger file used, if it is modified, ownership might have been violated',
  `subdomain_description` text NOT NULL COMMENT 'Some detailed descriptions about this subdomain',
  PRIMARY KEY (`subdomain_id`),
  UNIQUE KEY `subdomain_name_unique_index` (`subdomain_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of all sub-domains';

/**
* Skeleton of [Query Subdomains Categories: query_subdomains_categories]
* Grouping of subdomains based on these categories
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_subdomains_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Subdomain Categry ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink Weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Use this category?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved category?',
  `category_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Subdomain Category',
  `category_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Comments',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Grouping of subdomains based on these categories';

/**
* Skeleton of [Query Subdomains Status: query_subdomains_status]
* Development status of subdomain services
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_subdomains_status` (
  `status_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Status ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Active status?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved status?',
  `status_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Readable status name',
  `status_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Status Comments',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Development status of subdomain services';

/**
* Skeleton of [Query Tables: query_tables]
* List of all tables used within this application (exports)
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_tables` (
  `table_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Table ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Removed? Undesired export?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved table?',
  `in_merging` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Produce scripts for this table for merging subdomains?',
  `has_autoincrement` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Does this table have autu_incrementn field? Useful in creating MSSQL IDENTITY_INSERT ON flags',
  `export_structure` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Export table structure',
  `export_data` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Export Data, only if the structure was also allowed',
  `export_framework` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Export framework data as well?',
  `entity_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Entity name proposed for this table',
  `primary_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the primary key',
  `table_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The table name (with full name / prefix) to export',
  `table_comments` varchar(255) NOT NULL DEFAULT '' COMMENT 'Why this table? What does this table do?',
  `export_query` text NOT NULL COMMENT 'Partially import the data (Warning: SELECT * FROM .. WHERE...: All fileds in the same order); FULL and end with semicolon.',
  `export_query_reference` text NOT NULL COMMENT 'Reference/Backup',
  `export_comments` text NOT NULL COMMENT 'Extra comments',
  PRIMARY KEY (`table_id`),
  UNIQUE KEY `table_name_unique_key` (`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of all tables used within this application (exports)';

/**
* Skeleton of [Query Toc: query_toc]
* Table of contents for book chapters
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_toc` (
  `toc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'TOC Chapter ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent ID',
  `book_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which book?',
  `chapter_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Chapted - the depth level identifier',
  `added_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When added?',
  `fixed_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last modfied on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sorting',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Yes, No, Delete',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved TOC?',
  `toc_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title',
  `toc_text` text NOT NULL COMMENT 'Explanatory HTML body',
  PRIMARY KEY (`toc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table of contents for book chapters';

/**
* Skeleton of [Query Uploads: query_uploads]
* List of files uploaded using APIs
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_uploads` (
  `upload_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Upload ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Useless at the moment',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `upload_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'File size',
  `uploaded_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When uploaded?',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Total number of modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Useless at the moment',
  `image_width` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'If GD Image, get Width',
  `image_height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'If GD Image, get Height',
  `downloads_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Downloads, Impression',
  `file_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'Stamp Coded Name',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Real name of file',
  `file_mime` varchar(255) NOT NULL DEFAULT '' COMMENT 'MIME used while uploading',
  `file_location` varchar(255) NOT NULL DEFAULT '' COMMENT 'Directory, where this file is uploaded at',
  `comments_file` varchar(255) NOT NULL DEFAULT '' COMMENT 'Extra comments',
  `comments_additional` varchar(255) NOT NULL DEFAULT '' COMMENT 'Extra explanation to the source who uploaded this file',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Removed?',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Useless at the moment',
  PRIMARY KEY (`upload_id`),
  UNIQUE KEY `file_code_unique_index` (`file_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of files uploaded using APIs';

/**
* Skeleton of [Query Users: query_users]
* Users to login into the system
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Group ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `full_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Full name',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Login username (force to be email address)',
  `user_password` varchar(255) NOT NULL DEFAULT '' COMMENT 'Login password',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow to login? D = Account deleted',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Is this record approved?',
  `is_admin` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Give admin user rights?',
  `is_hidden` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Hide this user in the listing pages?',
  `do_export` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Export this account in default installations?',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_unique_index` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users to login into the system';

/**
* Skeleton of [Query Users Groups: query_users_groups]
* User groups to classify and set various permissions to them
* ==========================================================
* Timely view/truncate this table, as it may swell too soon.
*
* @author Bimal Poudel
* @package Backend Framework
*/

CREATE TABLE `query_users_groups` (
  `relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Relationship ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Group ID',
  `subdomain_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'For which Subdomain ID?',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Added on',
  `fixed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last time when CRON executed on this record',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modified on',
  `modified_counter` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of total modifications',
  `sink_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sink weight',
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Allow to login? D = Account deleted',
  `is_approved` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Approved user group?',
  `can_login` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'Can this group of users login?',
  `group_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Full group name',
  `group_description` text NOT NULL COMMENT 'Some description of this group of users',
  PRIMARY KEY (`relationship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User groups to classify and set various permissions to them';

