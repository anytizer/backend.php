Auto included classes are stored here.
Files in the (third) directories are included on demand only.

This is the inclusion hierarchy:
	interfaces
	datatypes
	common
	backend
	auto
	$_SERVER['SERVER_NAME']
	and, subdomain services

Modify inc/inc.config.php to add more auto-include locations.


11:15 PM 4/8/2010
If you make ./[server_name]/class.[class_name].inc.php,
it too will be used.