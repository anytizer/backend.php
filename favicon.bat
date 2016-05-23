@echo off

REM Creates desktop.ini file
echo [.ShellClassInfo] > desktop.ini
echo IconIndex=0 >> desktop.ini
echo IconFile=favicon.ico >> desktop.ini

REM Assigns attributes
attrib +S -H -R -A .
attrib +s +H +R -A desktop.ini
