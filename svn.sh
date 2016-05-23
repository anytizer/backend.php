#!/bin/bash

# Exports this application for a live production.
# Clears the ".svn" directories and files inside them.
# Tar/GZips the current entire directory.

rm -rf `find . -type d -name .svn`

GZIP=-9
rm -f ../latest.tar.gz
tar -zcf ../latest.tar.gz ./

# Now, upload latest.tar.gz in your server.
# Extract it inside your public_html; open in browser; and follow the instructions.

# Notices:
# Rather use svn export.
# GUI too works.
