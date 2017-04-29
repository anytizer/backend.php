3:39 PM 11/11/2009

Warning:
	This is a system directory and should NOT be used in __autoloader.
	It is used to dynamically create other controllers, classes and templates.

Comments
	To modify the comments on the files produced, edit the file:
		developer-comments.txt

header.html and footer.html
	These files are decorators only, for the screen.
	Not used elsewhere

Contains
	class.entity.inc.php
		Main class Model: library/classes/auto/class.*.inc.php
		Public Features for Database interaction:
			__construct()
			add()
			edit()
			delete()
			list_entries()
			details()
		Private features: For security
			sanitize()
			code()
			is_valid_code()

	controllers-entity-add.php
	controllers-entity-delete.php
	controllers-entity-details.php
	controllers-entity-edit.php
	controllers-entity-list.php
		Various Controllers: library/controllers/*.php

	entity-add.php
	entity-add-successful.php
	entity-add-error.php
	entity-details.php
	entity-delete.php
	entity-delete-successful.php
	entity-delete-error.php
	entity-direct-access-error.php
	entity-edit.php
	entity-edit-successful.php
	entity-edit-error.php
	entity-list.php
		User interaction and messaging

	developer-comments.txt
		Developer's copyright notices

	templates-entity-add.php
	templates-entity-edit.php
	templates-entity-list.php
		Essential Templates

	js-add.js
	js-edit.js
	js-list.js
		Validators: js/validators/*/*.js

	patches.sql
		SQL Installer (Creates a set of 12 files to be created)
		After creating files (with produce files option checked in, run the set of SQLs given on your screen)

This is a set of template files only, and is non-functional.
CRUDer class will handle all these files to produce a really functional classes and controllers.
And, it will put all these files in their own locations.

Just, run: http://<domain>/cruder.php and give a new CRUD name to begin.
