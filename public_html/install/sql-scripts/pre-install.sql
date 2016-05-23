# Run with ROOT permission

# Create a fresh database
DROP DATABASE IF EXISTS `MYSQLDATABASE`;

# Create your database
CREATE DATABASE `MYSQLDATABASE` CHARACTER SET utf8 COLLATE utf8_general_ci;

# Add a user to this database
GRANT ALL ON `MYSQLDATABASE`.* TO 'MYSQLUSERNAME'@'MYSQLHOSTNAME' IDENTIFIED BY 'MYSQLPASSWORD';

# Activate immediately
FLUSH PRIVILEGES;

# After completing this, call the file:
# 02-install-MYSQLDATABASE.bat
