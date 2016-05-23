
TRUNCATE `query_articles`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_articles.csv'
INTO TABLE `query_articles`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_cdn`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_cdn.csv'
INTO TABLE `query_cdn`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_code_generators`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_code_generators.csv'
INTO TABLE `query_code_generators`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_config`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_config.csv'
INTO TABLE `query_config`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_contacts`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_contacts.csv'
INTO TABLE `query_contacts`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_cruded`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_cruded.csv'
INTO TABLE `query_cruded`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_defines`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_defines.csv'
INTO TABLE `query_defines`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_development_history`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_development_history.csv'
INTO TABLE `query_development_history`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_distributions`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_distributions.csv'
INTO TABLE `query_distributions`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_downloads`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_downloads.csv'
INTO TABLE `query_downloads`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_dropdowns`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_dropdowns.csv'
INTO TABLE `query_dropdowns`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_emails`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_emails.csv'
INTO TABLE `query_emails`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_emails_smtp`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_emails_smtp.csv'
INTO TABLE `query_emails_smtp`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_errors`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_errors.csv' 
INTO TABLE `query_errors`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"' 
LINES TERMINATED BY '\r\n';


TRUNCATE `query_identifiers`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_identifiers.csv'
INTO TABLE `query_identifiers`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_licenses`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_licenses.csv'
INTO TABLE `query_licenses`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_logger`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_logger.csv'
INTO TABLE `query_logger`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_menus`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_menus.csv'
INTO TABLE `query_menus`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_messages`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_messages.csv'
INTO TABLE `query_messages`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_pages`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_pages.csv'
INTO TABLE `query_pages`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_server`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_server.csv'
INTO TABLE `query_server`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_sessions`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_sessions.csv'
INTO TABLE `query_sessions`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_subdomains`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_subdomains.csv'
INTO TABLE `query_subdomains`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_subdomains_categories`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_subdomains_categories.csv'
INTO TABLE `query_subdomains_categories`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_subdomains_status`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_subdomains_status.csv'
INTO TABLE `query_subdomains_status`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_tables`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_tables.csv'
INTO TABLE `query_tables`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_toc`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_toc.csv' 
INTO TABLE `query_toc`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"' 
LINES TERMINATED BY '\r\n';


TRUNCATE `query_uploads`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_uploads.csv'
INTO TABLE `query_uploads`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_users`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_users.csv'
INTO TABLE `query_users`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';


TRUNCATE `query_users_groups`;

LOAD DATA LOCAL INFILE '../public_html/install/sql-scripts/_csv/query_users_groups.csv'
INTO TABLE `query_users_groups`
FIELDS ESCAPED BY '\\' TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\r\n';

