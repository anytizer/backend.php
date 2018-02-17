<?php
namespace common;

/**
 * Various useful tools to generate random texts and other items
 * A common purpose tools collection.
 * Example: Useful in generating a random text string (automated passwords, ...), or sanitizing user inputs.
 *
 * @package Common
 */
class tools
{
    /**
     * Generates a random string of alphabets only
     */
    public static function random_alphabets($length = 4)
    {
        $length = (int)$length;
        if ($length <= 2 || $length >= 15) {
            $length = 7;
        }

        $random = array();
        for ($i = 0; $i < $length; ++$i) {
            $random[] = chr(65 + mt_rand(0, 25));
        }

        return implode("", $random);
    }

    /**
     * Generates a random string of composed of digits only
     */
    public static function random_digits($length = 4)
    {
        $length = (int)$length;
        if ($length <= 2 || $length >= 15) {
            $length = 7;
        }

        $random = array();
        for ($i = 0; $i < $length; ++$i) {
            $random[] = mt_rand(0, 9);
        }

        return implode("", $random);
    }

    /**
     * Only allows numbers and digits in a text
     */
    public static function sanitize_name($string = "")
    {
        return preg_replace('/[^a-z0-9]/is', "", $string);
    }

    /**
     * Only allows numbers and digits in a text
     */
    public static function alpha_numeric($string = "")
    {
        return preg_replace('/[^a-z0-9]+/is', "", $string);
    }

    /**
     * Clean up a string to make it usable within SQL statements.
     */
    public static function sanitize($string = "")
    {
        return addslashes($string);
    }

    /**
     * Allow alphabets only
     */
    public static function alphabetic($string = "")
    {
        $sanitized = preg_replace('/[^a-z]+/is', "", $string);

        return $sanitized;
    }

    /**
     * Wraps a word with a tick ( ` )
     * Particularly useful in creating SQL column names
     */
    public static function tick($word = "")
    {
        return "`{$word}`";
    }

    /**
     * Extracts the numbers only from a string
     * Example = in phones
     */
    public static function digits($string = "")
    {
        $digits = preg_split('/[^\d]+/', $string, -1);

        return implode("", $digits);
    }

    /**
     * Extracts the numbers only from a string
     * Example = in phones
     */
    public static function numeric($string = "")
    {
        $digits = preg_split('/[^\d]+/is', $string, -1);

        return implode("", $digits);
    }

    /**
     * Removes the Magic Quotes
     */
    public static function fix_slashes($array = "")
    {
        if ($array === null || empty($array)) {
            return null;
        }

        return is_array($array) ? array_map('fix_slashes', $array) : stripslashes($array);
    }

    /**
     * Adds the Magic Quotes
     */
    public static function add_slashes($array = "")
    {
        if ($array === null || empty($array)) {
            return null;
        }

        return is_array($array) ? array_map('add_slashes', $array) : addslashes($array);
    }

    /**
     * Sanitizes PHP file names: Allowed file name
     */
    public static function php_filename($filename = "")
    {
        $file = null;
        $data = array();
        if (preg_match('/^[a-z0-9\-\_]+\.php$/is', $filename, $data)) {
            # Enforces lower case names, case sensitive over unix systems.
            $file = strtolower($data[0]);
        }

        return $file;
    }

    /**
     * Sanitise a filename so that it guarantees saving.
     */
    public static function filename($filename = "")
    {
        $filename = preg_replace('/\s+/is', '-', $filename);
        $filename = preg_replace('/[^a-z0-9\.\,\_\-]+/is', '-', strtolower($filename));

        $filename = ($filename) ? strtolower($filename) : \common\tools::timestamp(); # Handles blank names

        return $filename;
    }

    /**
     * Send a date/time/random timestamp
     * uploader::stamp moved here on 2010-05-02
     */
    public static function timestamp()
    {
        # seed with microseconds
        list($microsoeconds, $seconds) = explode(' ', microtime());
        mt_srand((float)$seconds + ((float)$microsoeconds * 100000));

        # Now onwards, the length matters! Do NOT change it.
        # Generally it is of 18 characters, standardized within the framework.
        $stamp = date('YmdHis') . mt_rand(1000, 9999);

        return $stamp;
    }

    /**
     * Make a code, name or part of a word quite safe to use
     * and make sure it contains all valid characters.
     * SAFE means for SQL only, not a file name.
     * Particularly, it is a word for identifications.
     * So, some legal characters too are not allowed.
     */
    public static function safe_sql_word($string = "")
    {
        #$sanitized = preg_replace('/[^a-z0-9\:\ \,\.\=\_\-]+/is', "", $string);
        $sanitized = preg_replace('/[^a-z0-9\:\,\.\_\-]+/is', "", $string);

        return $sanitized;
    }

    /**
     * Load a subdomain specific class
     * This class file is probably not seen by the autoloaders.
     */
    public static function service_class($class_name = "")
    {
        $loaded = false;
        $class_file = __SUBDOMAIN_BASE__ . "/classes/class.<strong>{$class_name}</strong>.inc.php";
        if (file_exists($class_file)) {
            require_once($class_file);
            $loaded = true;
        } else {
            \common\stopper::message("Service class NOT found: {$class_file}");
        }

        return $loaded;
    }

    /**
     * Shorten the file name by auto suggesting for a long sentence.
     * Brings up the initials together.
     * Example:
     *    Full Name: Higher Secondary Education Act, 2046
     *    Shortened: hsea(2046)
     */
    public static function suggested_name($full_name = "")
    {
        $names = preg_split('/[^a-z0-9\-\_\.]+/is', strtolower($full_name));

        $parts = array();
        foreach ($names as $n => $name) {
            if (preg_match('/^[a-z]+$/is', $name)) {
                # Take the short name of the string
                $parts[] = $name[0];
            } elseif (preg_match('/^[0-9]+$/is', $name)) {
                # Prevent the numbers within braces
                $parts[] = '(' . $name . ')';
            } else {
                # Preserve the mixed as is
                $parts[] = $name;
            }
        }

        return implode("", $parts);
    }

    /**
     * Print out the current time of the server
     */
    public static function current_time()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Print out the current date by formatting a given date/time stamp
     */
    public static function ymd($timestamp = 0)
    {
        $ymd = date('Y-m-d');
        if (preg_match('/^[\d]{10}$/', $timestamp)) {
            $ymd = date('Y-m-d', $timestamp);
        }

        return $ymd;
    }

    /**
     * Returns unix time stamp, similar to UNIX_TIMESTAMP() in SQL
     * But be careful when the PHP/Apache server and MySQL servers are NOT same machines.
     *
     * @param string $yyyymmdd YYYY-MM-DD or YYYY-MM-DD HH:MM:SS, Optional (If this parameter is used, the corresponding value will me converted.)
     *
     * @return int
     */
    public static function unix_timestamp($yyyymmdd = '0000-00-00 00:00:00')
    {
        $time = 0;
        if ($yyyymmdd != "" && $yyyymmdd != '0000-00-00 00:00:00') {
            if (preg_match('/^[\d]{4}\-[\d]{2}-[\d]{2}$/', $yyyymmdd)) {
                # Converting date and adding 00:00:00 as assigned time
                $time = strtotime("{$yyyymmdd} 00:00:00");
            } elseif (preg_match('/^[\d]{4}\-[\d]{2}-[\d]{2} [\d]{2}\:[\d]{2}\:[\d]{2}$/', $yyyymmdd)) {
                # Converting full date/time
                $time = strtotime("{$yyyymmdd}");
            } else {
                # Error!
                # Optimistically read out zero instead because we had conversion error
                # die("\common\tools::Unix_Timestamp({$yyyymmdd}) - Input parameter error - not a date/time");
                $time = 0;
            }
        } else {
            # Current date time converted
            $time = time();
        }

        return $time;
    }

    /**
     * Alias of timestamp to create a unique code
     */
    public static function unique_code()
    {
        return self::timestamp(0);
    }

    /**
     * Generates random password
     */
    public static function password()
    {
        return self::random_text(6);
    }

    /**
     * Generates a random string
     */
    public static function random_text($length = 7)
    {
        $length = (int)$length;
        if ($length <= 2 || $length >= 15) {
            $length = 7;
        }

        $random = strtoupper(substr(md5(microtime()), mt_rand(5, 15), $length));

        return $random;
    }

    /**
     * Creates a directory, if it does not exist
     * Should be similar to `mkdir -p direcotry` in linux terminal
     * Warning: DO NOT MISUSE THIS TOOL.
     */
    public static function make_directory($full_path_directory = "")
    {
        $success = true;

        # Linux compatible naming under Windows.
        $full_path_directory = str_replace('\\', '/', $full_path_directory);
        $dirs = explode('/', $full_path_directory);

        $dir = "";
        foreach ($dirs as $d => $dirname) {
            $dir .= $dirname . '/';

            # Skip Windows drive letters
            if (preg_match('/\:/', $dirname)) {
                continue;
            }

            if (!is_dir($dir)) {
                if (is_file($dir)) {
                    # We can not create a file and a directory under one location, with same name.
                    \common\stopper::message("Problem: Can not create directory: <strong>{$dir}</strong>, a file name exists there.");
                    $success = false;
                    break;
                }

                # Try to make the directories recursively...
                if (!mkdir($dir, 0777)) {
                    \common\stopper::message("Can not create directory: <strong>{$dir}</strong>, may be due to permissions error.");
                    $success = false;
                    break;
                }
            }
        }

        # Instant notification
        #\common\stopper::message("<p class='writing'><strong>Making</strong>: {$full_path_directory}</p>", false);

        return $success;
    }


    /**
     * Reads the file contents from a matching list of argumented file names.
     * Aims to customize developer comments from the __SUBDOMAIN_BASE__ (subdomain).
     * Pass CSV list of file names to seek in order.
     * It will break after the first match.
     */
    public static function file_contents()
    {
        $fc = "";
        if (func_num_args() >= 1) {
            $files = func_get_args();
            foreach ($files as $f => $file) {
                $file = "{$file}"; # Force it to become a string.
                if (is_file($file)) {
                    $fc = file_get_contents($file);
                    break;
                }
            }
        }

        return $fc;
    }


    /**
     * Validates an array of input as the digits only.
     * Use for array filters only.
     * Known usages: entity::blockaction()
     *
     * @param int $number
     *
     * @return int|null The list contains only numbers
     */
    public static function numeric_only($number = 0)
    {
        return preg_match('/^[\d]+$/is', $number) ? $number : null;
    }

    /**
     * Renames a directory
     * Moves a directory and its contents into some other directory
     */
    public static function rename_directory($fullpath = '/tmp/directory', $rename_to = "")
    {
        # Smart validation
        $fullpath = realpath($fullpath);

        # The source directory should exist
        if (!is_dir($fullpath)) {
            return -1;
        }

        # if source is a single word (rename), use the same directory
        if (!preg_match('/[\/|\\]/', $rename_to)) {
            $rename_to = dirname($fullpath) . '/' . $rename_to;
        }

        # The target directory should NOT exist
        if (is_dir($rename_to)) {
            return -2;
        }

        # same directory cannot be renamed to
        if ($fullpath == $rename_to) {
            return -3;
        }

        # parent for the target should exist
        if (!is_dir(dirname($rename_to))) {
            return -4;
        }
        if (!is_writable(dirname($rename_to))) {
            return -5;
        }

        # Cross checking again
        # The target directory should NOT exist
        if (is_dir($rename_to)) {
            return -6;
        }

        #die("{$fullpath} =&gt; {$rename_to}");
        return rename($fullpath, $rename_to);
    }

    /**
     * Returns a COMMON file name extension (without dot) for the image files
     *
     * @link http://www.php.net/manual/en/function.image-type-to-extension.php
     */
    public static function extension($full_path_to_image = "")
    {
        $extension = 'null';
        if ($image_type = exif_imagetype($full_path_to_image)) {
            $extension = image_type_to_extension($image_type, false);
        }
        $known_replacements = array(
            'jpeg' => 'jpg',
            'tiff' => 'tif',
        );
        $extension = str_replace(array_keys($known_replacements), array_values($known_replacements), $extension);

        return $extension;
    }

    /**
     * Checks and returns defined value or supplied default value
     */
    public static function defined_constant($define_name = "", $default_value = "")
    {
        $value = "";
        if (defined($define_name)) {
            $value = constant($define_name);
        } else {
            $value = $default_value;
        }

        return $value;
    }

    /**
     * Converts US date into MM/DD/YYYY into YYYY-MM-DD database format
     */
    public static function fix_date($mmddyyyy = '00/00/0000')
    {
        global $regex_us_date;

        $dates = array();
        if (preg_match($regex_us_date, $mmddyyyy, $dates)) {
            /*
            Array
            (
                [0] => 08/08/2012
                [1] => 08
                [2] => 08
                [3] => 2012
            )
            */
            $mmddyyyy = "{$dates[3]}-{$dates[1]}-{$dates[2]}";
        }

        return $mmddyyyy;
    }

    /**
     * Guarantees YYYY-MM-DD data
     */
    public static function yyyymmdd($yyyymmdd = '0000-00-00')
    {
        global $regex_normal_date;
        $yyyymmdd = preg_match($regex_normal_date, $yyyymmdd) ? $yyyymmdd : null;

        return $yyyymmdd;
    }

    /**
     * Encrypts a string
     * @todo Fix for deprecation
     */
    public static function encrypt($string = "")
    {
        return $string;

        /**
         * @todo Warning: mcrypt_encrypt() supports only keys of sizes 16, 24 or 32.
         */
        $key1 = "FirstKeyLENGTH16";
        $key2 = "SECONDKEYLENGTHS";
        #if(!$string || !$key1 || !$key2) return false;

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key1, $string, MCRYPT_MODE_ECB, $key2);

        return trim(base64_encode($crypttext));
    }

    /**
     * Decrypts a string
     * @todo Fix for deprecation
     */
    public static function decrypt($cipher = "")
    {
        return $cipher;


        $key1 = "encryption key one";
        $key2 = "encryption key two";
        #if(!$cipher || !$key1 || !$key2) return false;

        $crypttext = base64_decode($cipher);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key1, $crypttext, MCRYPT_MODE_ECB, $key2);

        return trim($decrypttext);
    }

    /**
     * Make a safe directory name.
     * Theme: Without the trailing slash at the end, and double slashes in between the directory name
     */
    public function safe_directory_name($unsafe_directory_name = '/tmp')
    {
        # Begin by removing suspicious characters
        # Allow Windows drive [:, \]
        $safe_directory_name = $unsafe_directory_name;
        #$safe_directory_name = preg_replace('/[^a-z0-9\.\-\_\/\\\\:]/is', "", $safe_directory_name);

        # Convert to Linux compatibility
        $safe_directory_name = str_replace('\\', '/', $safe_directory_name);

        # Make single slash directory separator
        $safe_directory_name = preg_replace('/\/+/is', '/', $safe_directory_name);

        # Replace dots. Only one, non repeating dot is allowed
        $safe_directory_name = preg_replace('/[\.]{2,}+/is', '/', $safe_directory_name);
        $safe_directory_name = preg_replace('/\/\.\//is', '/', $safe_directory_name); # /./ => /

        # Remove trailing slash
        $safe_directory_name = preg_replace('/\/$/is', "", $safe_directory_name);

        return $safe_directory_name;
    }
}
