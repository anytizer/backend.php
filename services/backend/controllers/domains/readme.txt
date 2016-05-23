Entity: 	domains
Produced on:	2011-02-14 12:48:48 850


Patterns of controllers (of high priorities) are:
	domains-add.php
	domains-delete.php
	domains-details.php
	domains-edit.php
	domains-list.php

	# Public pages
	domains-list-public.php
	domains-details-public.php

	domains.php


Or, with less priorities,
	domains/add.php
	domains/delete.php
	domains/details.php
	domains/edit.php
	domains/list.php

	# Public pages
	domains/list-public.php
	domains/details-public.php

	# Repeated again, here.
	domains.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: domains-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.