#!/bin/bash
# Cleans up the temp directories and caches.
# Run this script regularly.

# Remove compiled files
rm -f library/tmp/smarty_compiles/*.tmp
rm -f library/tmp/smarty_compiles/*.php

# System specific resources
# rm -f library/tmp/cache-menus/*.php
# rm -f library/tmp/cache-menus/*.serialized
# rm -f library/tmp/cache-menus/*.tmp
rm -f library/tmp/sqls/*.log
rm -f library/tmp/to_javascript/*.js
# rm -f library/tmp/superfish/*.php

# ipconfig /flushdns
# Application specific resources
# rm -f xml/tmp/*.xml
