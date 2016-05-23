@ECHO OFF

REM Flushes local DNS caches.
REM Helps to switch a domain name between local/server IPs.
REM Run this file after you modify the "hosts" file.
ipconfig /flushdns

REM Cleans up the temp directories and caches.
REM Run this script regularly.
REM System specific resources

DEL /F /Q library\tmp\smarty_compiles\*.tmp
DEL /F /Q library\tmp\smarty_compiles\*.php
REM DEL /F /Q library\tmp\cache-menus\*.php
REM DEL /F /Q library\tmp\cache-menus\*.serialized
REM DEL /F /Q library\tmp\cache-menus\*.tmp
DEL /F /Q library\tmp\sqls\*.log
REM DEL /F /Q library\tmp\to_javascript\*.js
REM DEL /F /Q library\tmp\superfish\*.php

REM Application specific resources
DEL /F /Q xml\tmp\*.xml

PAUSE
EXIT
