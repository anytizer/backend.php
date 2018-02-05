<?php
$lines = file_get_contents("lint-checker.bat");
$replace = preg_quote(__DIR__.DIRECTORY_SEPARATOR);

$lines = preg_replace('/'.$replace.'/is', "php -l ", $lines);
file_put_contents("lint-checker.bat", $lines);

# unlink("lint-checker.bat");
