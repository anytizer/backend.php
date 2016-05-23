By-Passing PHP's safe_mode restrictions - which would disallow to use $smarty->templateExist():
Add the first line, instead of the second line in the static.php template file:

Use:
{if $page.include_file}{include file=$page.include_file}{/if}

Instead of:
{if $page.include_file|valid_template}{include file=$page.include_file}{/if}

See the details at Smarty Forum:
http://www.smarty.net/forums/viewtopic.php?t=17450




Null Template (null.php)
==============================================================================
	Zero sized
	For stopping after controlller's execution.
	Display is held within the controller only.


Blank (blank.php)
==============================================================================
	Empty HTML template.
	For warning that a particular template was missing.


Home (home.php)
==============================================================================
	Home page is different than the other pages.


Index Blocker (index.php)
==============================================================================
	Hides listing other template files.
	Contains empty html or reletated messaging.


404 Error Template (404.php)
==============================================================================
	Softly warn about missing template, but still referenced.


Clear Template (clear.php)
==============================================================================
	No header/footer.
	Examples - to be used in javascript popups.
	Lightboxes.


Static Template (static.php)
==============================================================================
	A general purpose template to assemble pieces of template resources.
	Commonly used for front end display.
	Defaults from the database records.


Management (management.php)
==============================================================================
	Admin Template.
	Add/Edit/Delete/Update, CRUD operator template.


Some notes on templating system:
query_pages table can refer to the template names per page!
You can add as many template files as you like.


Elements you can print by default:
==============================================================================

Page Title
	{$page.page_title|default:'Company Name'}

Meta Keywords
	{$page.meta_keywords|default:'Backend Framework, Company Name'}

Meta Descriptions
	{$page.meta_description|default:'Application framework made by Company Name'}

Page Title
	{$page.content_title|default:'No title'}

Include the external sub-template file
Note: You must validate this sub-template file first.
	{if $page.include_file|valid_template}{include file=$page.include_file}{/if}

Calling {menus} function: It needs <ul>, </ul> wrapping.
	Loading menus - an example
		<ul class="links-collection">{menus context='framework:admin'}</ul>