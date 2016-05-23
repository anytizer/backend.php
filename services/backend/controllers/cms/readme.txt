Entity: 	cms
Produced on:	2011-02-09 23:25:11 836


Patterns of controllers (of high priorities) are:
	cms-add.php
	cms-delete.php
	cms-details.php
	cms-edit.php
	cms-list.php

	# Public pages
	cms-list-public.php
	cms-details-public.php

	cms.php


Or, with less priorities,
	cms/add.php
	cms/delete.php
	cms/details.php
	cms/edit.php
	cms/list.php

	# Public pages
	cms/list-public.php
	cms/details-public.php

	# Repeated again, here.
	cms.php


However, the second option has multiple advantages.
It helps you to group the files within one directory for each entity.
So, it seems better managed.


Any other files within this directory will be disregarded by default.
Rather, use: cms-[action].php file in the parent directory.


Developer's notes:
Every single file should have to registed in query_pages table.
If you register more files, you can use them.
Every file follows the priority patterns as defined earlier.