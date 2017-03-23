@echo off
dir /s/a/b *.php > lint-checker.bat

php -f php-linter.php

lint-checker.bat > lint-checker.log
php -r "unlink('lint-checker.bat');"
