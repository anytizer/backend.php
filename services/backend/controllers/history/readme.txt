Entity: 	history
Produced on:	2010-12-27 11:38:12 391


Patterns of controllers (of high priorities) are:
	history-add.php
	history-delete.php
	history-details.php
	history-edit.php
	history-list.php

	# Public pages
	history-list-public.php
	history-details-public.php

	history.php


Or, with less priorities,
	history/add.php
	history/delete.php
	history/details.php
	history/edit.php
	history/list.php

	# Public pages
	history/list-public.php
	history/details-public.php

	# Repeated again, here.
	history.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: history-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.