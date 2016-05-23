Entity: 	cdn
Produced on:	2010-11-15 13:36:42 243


Patterns of controllers (of high priorities) are:
	cdn-add.php
	cdn-delete.php
	cdn-details.php
	cdn-edit.php
	cdn-list.php

	# Public pages
	cdn-list-public.php
	cdn-details-public.php

	cdn.php


Or, with less priorities,
	cdn/add.php
	cdn/delete.php
	cdn/details.php
	cdn/edit.php
	cdn/list.php

	# Public pages
	cdn/list-public.php
	cdn/details-public.php

	# Repeated again, here.
	cdn.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: cdn-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.