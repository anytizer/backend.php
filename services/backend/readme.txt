Directory Structures for toc
Location: library/services/backend/
	Put all files in this location.

controllers: Controllers for this service only
classes: PHP Classes needed for this service only

configs: Smarty configurations if needed
plugins: On demand Smarty plugins for this service only

sqls: Sets of SQLs to register pages. Be careful with with the subdomain ID.

templates: Smarty templates
templates/css: CSS files used with the templates (now act as parent css/*.css names
templates/images: Image files used with the templates (now act as parent images/*.??? names

js: Holds subdomain specific js files (name should be different as that in parent js directory)
	These js files should be used straight forward, without {js} plugin function.