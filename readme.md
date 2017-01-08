# Backend CRUD Generator

This tool is used to generate website from your raw database.

The output consists of admin and frontend interfaces with user roles and limits.

Requirement of this tool was to speedup website generation with some notable requirements like:

 * Every developer involved in the project should write similar patterns of code.
 * The website has to be easily themeable by the designer.
 * The database may be unstable and might change even after writing the necessary PHP Code for this.
 * Troubleshooting a bug made easy.
 * Same website can act as Desktop, Moile or API Version.
 * Application should support genral programming requirements like:
   - Sending out emails
   - Uploading image files with resize options
   - Uploading other documents

Scripts generation made easy with __themeable__ HTML ouput.

 * Just focus your efforts on better database design.
 * It will create an admin panel for you.


## Necessary steps

 * First, design your database based on your project's specific needs.
 * Standarise the naming conventions.
 * Apply system level flags on all tables.
 * Apply Column comments *(compulsory)*
 * Generate the HTML Code for your database.
 * Write certain sppecific business logic codes to fulfill your requrements.
 * Theme your website.
 * Done!


## PHP Requirements
 * Preferred: PHP 7
 * Minimum: 5.4
 * Use latest XAMPP as your development environment


## MySQL Requirements
 * MariaDB (latest version)
 * MySQL (latest version)
 * Removed support to other databases


## Future Enhancement
 * To use AngularJS for listing the tables
 * Manage bulk operations via Ajax/JSON