<?php
/**
 * Custom define a constant
 */
function defines($name = '', $value = '')
{
	if(!defined($name))
	{
		define($name, $value, false);
	}

	return null;
}

# Load some crucial, but undefined constants.
# It expects them in the database: Query Defines.

# Pagination helper: The per-page listing flag
# Some sites might have used query_defines to define...
# load_user_defined_constants_per_subdomain
defines('__PER_PAGE__', 50);

# Server and "service location" specific settings.
# For MySQL client connection
defines('__TIMEZONE_NUMERIC__', '+5:45');

# Timezones in text has Spelling errors.
# Refer to the PHP's manual as well.
# Keep this value compatible with __TIMEZONE_NUMERIC__.
# @url http://php.net/manual/en/timezones.php
defines('__TIMEZONE_TEXT_PHP__', 'Asia/Kathmandu');
if(function_exists('date_default_timezone_set'))
{
	date_default_timezone_set(__TIMEZONE_TEXT_PHP__);
}

# Default/Expected base storage location of a subdoman service/application
# If not defined earlier in the database, __SUBDOMAIN_BASE__ can be relocated from here.
defines('__SUBDOMAIN_BASE__', __SERVICES_PATH__.'/' . $_SERVER['SERVER_NAME']);

# Who owns the scripts at the moment?
# Used in error pages or where relevant.
defines('__DEVELOPER_URL__', 'http://www.example.com/');
defines('__DEVELOPER_NAME__', 'Company Name');
defines('__FRAMEWORK_NAME__', 'Backend Framework');
# These constatns are also defined in library/inc/inc.contstants.php

# Only to build FULL URLs, edit this value.
# However, most of the pages work in relative paths
# It works by changing hosts file, on a local system.
# Write without trailing slash /
defines('__URL__', (__LIVE__) ? 'http://' . $_SERVER['SERVER_NAME'] : 'http://' . $_SERVER['SERVER_NAME'] . '/backend/backend/public_html');