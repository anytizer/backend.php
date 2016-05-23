12:44 AM 6/17/2010

This directory contains [Auto-Generated] SQL scripts.
Each script is produced after significant modification in the database.

Run all of these scripts on your computer to complete the installation of databases needed by the framework.

The *.sh and *.bat scripts are within batch-scripts.
Bring them here.

On Windows, run, install.bat for quick instalation.


Installation technique: (Use single.bat file)
	copy *.struct structure.sql
	mysql < structure.sql

	copy *.dat data.sql
	mysql < data.sql

Note: *.dat files are CSV files.

Fake/invalid tables with query_ prefix
	query_actions
	query_boxes
	query_boxes_static
	query_cruded
	query_linux_commands
	query_sites

Remove them.

Auto Installation
=================================
Use install.sh for more details.
It also imports *.struct files wherever you are in.