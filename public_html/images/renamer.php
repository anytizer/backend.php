<?php
header('Content-Type: text/plain');

function new_name($file = "")
{
    $file = preg_replace('/[^a-z0-9]+/is', '-', $file);
    if (preg_match('/^.*?php$/', $file)) {
        return null;
    }

    return strtolower($file);
}

function rename_files($dir = "")
{
    if ($handle = opendir($dir)) {
        echo "Directory handle: $handle\r\n";
        echo "Files:\n";

        while (false !== ($file = readdir($handle))) {
            $new_file = new_name($file);
            if ($new_file) {
                rename($file, $new_file);
                echo "{$file} = {$new_file}\n";
            }
        }
    }
}

rename_files('./');
