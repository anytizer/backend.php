#!/bin/bash

cd database/MYSQLDATABASE

# Installs the database scripts on a FRESH database.# Please set the PATH to mysql/bin if NOT available already.
# Configure MYSQL Parameters for administrative purposeHOSTNAME=MYSQLHOSTNAMEUSERNAME=MYSQLUSERNAMEPASSWORD=MYSQLPASSWORDDATABASE=MYSQLDATABASE
# Copies all of the table structures into structure.sql
echo > 03-structure.sqlrm -f 03-structure.sqlcat ../../public_html/install/sql-scripts/_struct/*.struct > 03-structure.sql
# Copies all of the table table data into data.sqlecho > 04-data.sqlrm -f 04-data.sqlcat ../../public_html/install/sql-scripts/_dat/*.dat > 04-data.sql
# Loads the table structuers into the database.mysql -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} ${DATABASE} < 03-structure.sql
# Loads the csv files into the database.# @todo ERROR 1148 (42000) at line 4: The used command is not allowed with this MariaDB version
# Fix Path to CSV Filesmysql --local_infile=1 -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} ${DATABASE} < 04-data.sql
# Post installation: Reset usernames and passwords.mysql -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} ${DATABASE} < 04-post-install-${DATABASE}.sql
# Produce the database dumper script# To be run after database has been created once and installed# Produces the database dump right after installation# @todo Backup script MISSING > charactermysqldump -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} ${DATABASE} > dump-${DATABASE}.sql
echo -e '#!/bin/bash' > backup-${DATABASE}.sh
echo "mysqldump -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} ${DATABASE} > dump-${DATABASE}.sql" >> backup-${DATABASE}.shchmod 755 backup-${DATABASE}.sh
echo Done!