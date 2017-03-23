@echo off

REM creates desktop.ini file
ECHO [.shellclassinfo] > desktop.ini
ECHO iconindex=0 >> desktop.ini
ECHO iconfile=favicon.ico >> desktop.ini
COPY /y favicon.ico public_html\favicon.ico

REM assigns attributes
ATTRIB +s -h -r -a .
ATTRIB +s +h +r -a desktop.ini
PAUSE
