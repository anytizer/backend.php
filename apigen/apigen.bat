@echo off
curl -L -O https://github.com/ApiGen/ApiGen.github.io/raw/master/apigen.phar
php apigen.phar generate -s ../library -d ../documentation
