Entity: 	licenses
Produced on:	2011-02-10 00:12:27 318


Patterns of controllers (of high priorities) are:
	licenses-add.php
	licenses-delete.php
	licenses-details.php
	licenses-edit.php
	licenses-list.php

	# Public pages
	licenses-list-public.php
	licenses-details-public.php

	licenses.php


Or, with less priorities,
	licenses/add.php
	licenses/delete.php
	licenses/details.php
	licenses/edit.php
	licenses/list.php

	# Public pages
	licenses/list-public.php
	licenses/details-public.php

	# Repeated again, here.
	licenses.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: licenses-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.