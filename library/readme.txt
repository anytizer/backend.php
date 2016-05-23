Main application files reside here.

DO NOT REMOVE index.php FILE.
It is being accessed from other locations as well.

classes
	Main class files to include

controllers
	Parent level controller files

inc
	Generally included files

smarty_cache
	Smarty's cache directory

smarty_compiles
	Smarty's compile directory

modules
	Third party development
	Independent components

Security
	This aims a big secured system.
	$_GET,  $_POST, $_SESSION
		These variables are NOT accessed directly.
		Every access is defined with VARIABLE class.

SQL safety
	No DELETE() call in SQL.
	Every data is stored in the system for legal reviews or history keeping.