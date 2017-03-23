#!/usr/bin/env bash
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar update

./vendor/bin/phpunit

# https://github.com/adoxa/ansicon/releases
# c:\ansicon\ansicon -i
# .\vendor\bin\phpunit
