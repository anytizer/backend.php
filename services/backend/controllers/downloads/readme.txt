Entity: 	downloads
Produced on:	2010-12-14 00:48:38 194


Patterns of controllers (of high priorities) are:
	downloads-add.php
	downloads-delete.php
	downloads-details.php
	downloads-edit.php
	downloads-list.php

	# Public pages
	downloads-list-public.php
	downloads-details-public.php

	downloads.php


Or, with less priorities,
	downloads/add.php
	downloads/delete.php
	downloads/details.php
	downloads/edit.php
	downloads/list.php

	# Public pages
	downloads/list-public.php
	downloads/details-public.php

	# Repeated again, here.
	downloads.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: downloads-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.