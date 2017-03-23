<?php
$lines = file_get_contents("lint-checker.bat");
$replace = preg_quote(dirname(__FILE__).DIRECTORY_SEPARATOR);

$lines = preg_replace('/'.$replace.'/is', "php -l ", $lines);
file_put_contents("lint-checker.bat", $lines);

# unlink("lint-checker.bat");
