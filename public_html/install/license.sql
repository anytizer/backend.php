# MySQL Documentation
# To obtain a random integer R in the range i <= R < j,
# use the expression FLOOR(i + RAND() * (j – i)).
# For example, to obtain a random integer in the range the range 7 <= R < 12,
# you could use the following statement: 
# SELECT FLOOR(7 + (RAND() * 5));

# Single random digit
SELECT (FLOOR(0 + (RAND() * 9))%10) d; # 0-9

INSERT INTO query_licenses (
	added_on, modified_on, expires_on,
	is_active,
	application_name,
	server_ip, server_name,
	installed_on,
	protection_key, license_key,
	license_email
) VALUES (
	UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), UNIX_TIMESTAMP(DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 YEAR)),
	'Y',
	'Backend Framework',
	INET_ATON('192.168.0.1'), 'www.example.com',
	CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP(), '%Y%m%d%H%i%S'), '9999'),
	'protectionkey', MD5(CONCAT('protectionkey', 'www.example.com')),
	'lic1@example.com'
);