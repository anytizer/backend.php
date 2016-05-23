#!/bin/sh
# Alias of SVN/hooks/post-commit
 
REPOS="$1"
TXN="$2"

svn update --force --quiet /FULL-PATH/
wget --quiet http://NOTIFYSERVER/commit/?project=PROJECT&revision=${REV}&repos=${REPOS} > /dev/null