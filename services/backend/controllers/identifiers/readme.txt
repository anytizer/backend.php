Entity: 	identifiers
Produced on:	2011-03-18 13:20:47 198


Patterns of controllers (of high priorities) are:
	identifiers-add.php
	identifiers-delete.php
	identifiers-details.php
	identifiers-edit.php
	identifiers-list.php

	# Public pages
	identifiers-list-public.php
	identifiers-details-public.php

	identifiers.php


Or, with less priorities,
	identifiers/add.php
	identifiers/delete.php
	identifiers/details.php
	identifiers/edit.php
	identifiers/list.php

	# Public pages
	identifiers/list-public.php
	identifiers/details-public.php

	# Repeated again, here.
	identifiers.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: identifiers-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.