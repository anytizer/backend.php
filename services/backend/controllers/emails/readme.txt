Entity: 	emails
Produced on:	2011-03-23 11:38:46 911


Patterns of controllers (of high priorities) are:
	emails-add.php
	emails-delete.php
	emails-details.php
	emails-edit.php
	emails-list.php

	# Public pages
	emails-list-public.php
	emails-details-public.php

	emails.php


Or, with less priorities,
	emails/add.php
	emails/delete.php
	emails/details.php
	emails/edit.php
	emails/list.php

	# Public pages
	emails/list-public.php
	emails/details-public.php

	# Repeated again, here.
	emails.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: emails-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.