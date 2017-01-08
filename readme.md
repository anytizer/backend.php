# Backend CRUD Generator

"_Make a fairly complex website in just a day._" Rather, spend your time in good database design.

This tool is used to generate frontend and backend website from your raw database.

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
 * Standardize the naming conventions.
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


## Technolgies used

 * [Smarty Template Engine](http://www.smarty.net/)
 * [PHPMailer](https://github.com/PHPMailer/PHPMailer)
 * [Compass](http://compass-style.org/)/[SCSS](http://sass-lang.com/), [CSS](https://www.w3.org/TR/CSS/)
 * [W3CSS](http://www.w3schools.com/w3css/)
 * [HTML](https://www.w3.org/TR/html5/), JavaScript
 * [PHP](http://php.net/manual/en/), [Shell Scripts](http://www.shellscript.sh/), [Curl](https://curl.haxx.se/), [.bat]()
 * [FileZilla](https://filezilla-project.org/), [SSH](https://en.wikipedia.org/wiki/Secure_Shell), [Putty](http://www.chiark.greenend.org.uk/~sgtatham/putty/)
 * [MariaDB](https://mariadb.org/), [MySQL](http://www.mysql.com/) and command line utilities
 * [XAMPP](https://www.apachefriends.org/)
 * [SQLYog](https://github.com/webyog/sqlyog-community/wiki/Downloads), [HeidiSQL](http://www.heidisql.com/)
 * [JQuery](http://jquery.com/), [AngularJS](https://angularjs.org/)
 * [Apache](https://en.wikipedia.org/wiki/Apache_HTTP_Server), [.htaccess](https://httpd.apache.org/docs/2.4/howto/htaccess.html)
 * [ApiGen](http://www.apigen.org/)
 * [Ubuntu](https://www.ubuntu.com/), [CentOS](https://www.centos.org/), [Raspbian](https://www.raspberrypi.org/downloads/raspbian/), [Windows](https://www.microsoft.com/en-us/windows)
 * [PHPUnit](https://phpunit.de/)
 * [JSON](http://www.json.org/), CSV, XML, Parsers
 * [Composer](https://getcomposer.org/)
 * [GIT SCM](https://git-scm.com/), [Tortoise Git](https://tortoisegit.org/), [GitHub](https://github.com/), ~~[Tortoise Subversion](https://tortoisesvn.net/)~~
 * [PHPStorm IDE](https://www.jetbrains.com/phpstorm/), [Notepad++](https://notepad-plus-plus.org/)

There may be alternative links to the products above.


## Future Enhancement

 * To use AngularJS for listing the tables
 * Manage bulk operations via Ajax/JSON
