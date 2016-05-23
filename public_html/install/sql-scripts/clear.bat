@ECHO OFF

REM Removes the auto-created batch scripts.
DEL /Q install-*.bat

REM Remove the other SQL files
DEL /Q *.dat
DEL /Q *.csv
DEL /Q *.struct

REM Remove pre-install files.
DEL /Q pre-install-*.sql

REM Remove dynamic scripts
DEL /Q data.sql
DEL /Q structure.sql