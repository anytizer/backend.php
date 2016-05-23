#!/bin/sh
svn info . | awk '/Revision/ { print $2; }' > revision.txt
