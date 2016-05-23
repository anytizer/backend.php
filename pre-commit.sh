#!/bin/sh
 
REPOS="$1"
TXN="$2"
 
# Make sure that the log message contains some text.
SVNLOOK=/usr/bin/svnlook
SVNLOOK_OK=1
$SVNLOOK log -t "$TXN" "$REPOS" | \
grep "[a-zA-Z0-9]" > /dev/null || SVNLOOK_OK=0
if [ $SVNLOOK_OK = 0 ]; then
  echo Please provide a proper change log message. 1>&2
  exit 1
fi
exit 0