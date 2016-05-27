@ECHO OFF
REM Installs the database scripts on a FRESH database.
REM Please set the PATH to mysql/bin if NOT available already.


REM Configure MYSQL Parameters for administrative purpose
SET MYSQLHOSTNAME=MYSQLHOSTNAME
SET MYSQLUSERNAME=MYSQLUSERNAME
SET MYSQLPASSWORD=MYSQLPASSWORD
SET MYSQLDATABASE=MYSQLDATABASE


REM copies all of the table structures into structure.sql
ECHO > 03-structure.sql
DEL /Q /F 03-structure.sql
copy /B ..\public_html\install\sql-scripts\_struct\*.struct 03-structure.sql


REM copies all of the table table data into data.sql
ECHO > 04-data.sql
DEL /Q /F 04-data.sql
copy /B ..\public_html\install\sql-scripts\_dat\*.dat 04-data.sql


REM Loads the table structuers into the database.
mysql -h%MYSQLHOSTNAME% -u%MYSQLUSERNAME% -p%MYSQLPASSWORD% %MYSQLDATABASE% < 03-structure.sql


REM Loads the csv files into the database.
REM @todo ERROR 1148 (42000) at line 4: The used command is not allowed with this MariaDB version
mysql --local_infile=1 -h%MYSQLHOSTNAME% -u%MYSQLUSERNAME% -p%MYSQLPASSWORD% %MYSQLDATABASE% < 04-data.sql


REM Post installation: Reset usernames and passwords.
mysql -h%MYSQLHOSTNAME% -u%MYSQLUSERNAME% -p%MYSQLPASSWORD% %MYSQLDATABASE% < 04-post-install-%MYSQLDATABASE%.sql


REM Produce the database dumper script
REM To be run after database has been created once and installed
REM Produces the database dump right after installation
REM @todo Backup script MISSING > character
mysqldump -h%MYSQLHOSTNAME% -u%MYSQLUSERNAME% -p%MYSQLPASSWORD% %MYSQLDATABASE% > dump-%MYSQLDATABASE%.sql
ECHO mysqldump -h%MYSQLHOSTNAME% -u%MYSQLUSERNAME% -p%MYSQLPASSWORD% %MYSQLDATABASE% ^> dump-%MYSQLDATABASE%.sql > backup-%MYSQLDATABASE%.bat


ECHO Done!
PAUSE
