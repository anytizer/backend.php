#!/bin/bash

# Get the project
git clone https://github.com/bimalpoudel/backend.git backend
cd backend

# Accept the GIT file differences
git config --global core.filemode false
git config --global core.autocrlf true

chmod -R 777 services 
chmod -R 777 tmp
chmod -R 777 database

# Patch for new setup
rm -rf database/*/
rm -f database/config.mysql.inc.php
rm -f database/license.ini
git checkout *
git pull

# Browse the site
# http://.../backend/public_html/install/

cd database/*/
chmod 755 *.sh
./03-install-*.sh

mklink /d public_html backend\public_html

edit: public_html/inc.bootstrap.php

Browse:
http://localhost/backend/live/public_html/

Login Username: USERNAME
Login Password: PASSWORD

Create Subdomain
Give paths
Install

First CRUD



# basic chmod
chmod -R 777 library/services 
chmod -R 777 library/tmp/cache-menus 
chmod -R 777 library/tmp/curl-cookies 
chmod -R 777 library/tmp/errors 
chmod -R 777 library/tmp/smarty_cache 
chmod -R 777 library/tmp/smarty_compiles 
chmod -R 777 library/tmp/superfish 
chmod -R 777 install/sql-scripts 
chmod -R 777 library/classes/common/config.mysql.inc.php 
chmod -R 777 library/services/backend/config.mysql.inc.php

# License permission file
touch install/license.txt
chmod 777 install/license.txt

# Edit the mysql configuration file
vi library/classes/common/config.mysql.inc.php
