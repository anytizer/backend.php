10:53 AM 9/16/2010
Special warning:
backend is urgent directory.
If you create a different super-admin subdomain, do not just rename this directory.
Rather, make a copy of backend to your suitable super admin name.
Example:
	cp -R backend superadmin.mydomain.com
	This is to avoid absence of core files in backend.


12:32 AM 6/17/2010
Put all of your business applications here...
NEVER put them into .svn if:
	They ARE NOT FREE.
	They are closed sourced applications.
	They are commercial apps for the customers.
	They are meant for sale.

Include applications in this directory into .svn if:
	They are free applications.
	They are demo tools.
	They are open sourced.
	They are not meant for sale.
	They are for public access.

Directory structures
	sub.domain.name
	|_ rewrite.ini: Additional router
	|_ classes: Your class files (class.CLASSNAME.inc.php)
	|_ configs: Smarty config data
	|_ controllers: handlers for user requests
	|_ js: All of your javascripts, as seen as /js/*.js
	|_ plugins: Smarty plugins
	|_ sqls: Administrative - to atu generate sqls for entities
	|_ templates: Smarty templates
	   |- css: CSS Files
	   |_ images: Images files

Any other documents inside here will NOT be visible to the web.
So, it is safe to put your business documents, sheets, plans,
reports and other kinds of documents.		


============================================================
This directory is a subdomain service using the framework.
As this section may contain items in a commecial production,
please avoid it from the SVN upload/download.

Free/Stand Alone subdomain services
	localhost (distributed as a sample CMS application)
	backend (distribution continued as a core framework)
	(a real time example on primitive use of this framework)
