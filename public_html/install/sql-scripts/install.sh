#!/bin/bash
# Installs the database scripts on a FRESH database.
# Please set the PATH to mysql/bin if NOT available already.


# Configre MYSQL Parameters for administrative purpose
MYSQLHOSTNAME=MYSQLHOSTNAME
MYSQLUSERNAME=MYSQLUSERNAME
MYSQLPASSWORD=MYSQLPASSWORD
MYSQLDATABASE=MYSQLDATABASE


# copies all of the table structures into structure.sql
rm -f structure.sql
cat ../public_html/install/sql-scripts/_struct/*.struct > structure.sql


# copies all of the table table data into data.sql
rm -f data.sql
cat ../public_html/install/sql-scripts/_dat/*.dat > data.sql


# Loads the table structuers into the database.
mysql -h${MYSQLHOSTNAME} -u${MYSQLUSERNAME} -p${MYSQLPASSWORD} ${MYSQLDATABASE} < structure.sql


# Loads the csv files into the database.
mysql -h${MYSQLHOSTNAME} -u${MYSQLUSERNAME} -p${MYSQLPASSWORD} ${MYSQLDATABASE} < data.sql


# Post installation: Reset usernames and passwords.
mysql -h${MYSQLHOSTNAME} -u${MYSQLUSERNAME} -p${MYSQLPASSWORD} ${MYSQLDATABASE} < post-install.sql


echo "Done\!"