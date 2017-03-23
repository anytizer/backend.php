<?php
namespace common;

/**
 * Generic all kinds of validations, used in server side validation process.
 *
 * @package Common
 */
class server_side_validator
{
    public $errors;
    public $unknown_error_message;

    public function __construct()
    {
        $this->errors = array();
        $this->unknown_error_message = 'Unknown error'; # Useful for translations
    }

    /**
     * Check if an application validation is totally error free or not.
     * Useful in displaying the error messages.
     */
    public function is_valid()
    {
        $is_valid = (count($this->errors) == 0);
        return $is_valid;
    }

    /**
     * Data can not be blank.
     */
    public function validate_not_empty(&$value, $message = "")
    {
        $success = true;
        if (empty($value)) {
            $success = false;
            $this->add_error($message);
        }

        return $success;
    }

    public function add_error(&$message)
    {
        if (!empty($message)) {
            $this->errors[] = $message;
        } else {
            $this->errors[] = $this->unknown_error_message;
        }

        return false;
    }

    /**
     * No validations at all. This is the default validation, and should NOT be used programmatically.
     * Considerable with automated systems: Always returns true.
     */
    public function validate_anything(&$value, $message = "")
    {
        return true;
    }

    /**
     * Validate texts (alphabets and space)
     */
    public function validate_text(&$value, $message = "")
    {
        $success = false;
        if (preg_match("/^[a-z\ ]+$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate numbers
     */
    public function validate_number(&$value, $message = "")
    {
        $success = false;
        if (preg_match("/^[0-9]+$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate time in HH:MM:SS, 24 hours time format
     */
    public function validate_time(&$value, $message = "")
    {
        $success = false;
        #if(preg_match("/^[0-9]{2}\:[0-9]{2}\:[0-9]{2}$/is", $value))
        if (preg_match("/^[012][0-9]\:[0-5][0-9]\:[0-5][0-9]$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate that the input comprises of words.
     * Uses a portion of validating a single word.
     */
    public function validate_words(&$value, $message = "")
    {
        #echo("Validating: {$value}");
        $v = trim($value);
        if (empty($v)) {
            $this->add_error($message);

            return false;
        }

        $words = explode(' ', $v);
        $words = array_map('trim', $words);
        foreach ($words as $w => $word) {
            if (empty($word)) {
                unset($words[$w]);
            } else {
                #echo("<br>Checking: {$word}");
                #if(!$this->validate_word($word, "Invalid word ( {$word} )"))
                if (!$this->validate_word($word, ($message) ? "{$message} ( {$word} )" : "Invalid word ( {$word} )")) {
                    return false;
                }
            }
        }

        return count($words) >= 1;
    }

    /**
     * Validate word as atomic group of alphabets only.
     */
    public function validate_word(&$value, $message = "")
    {
        $success = false;
        $value = trim($value);
        if (!empty($value) && preg_match("/^[a-z]+$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate floating point number
     */
    public function validate_float(&$value, $message = "")
    {
        $success = false;
        if (preg_match("/^[\-\+]?[0-9]*\.?[0-9]+$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate money amount, with two digits in the decimal
     * A subset of float type numbers.
     */
    public function validate_money(&$value, $message = "")
    {
        $success = false;
        if (preg_match("/^[\-\+]?[0-9]*\.?[0-9]{2}$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate mixed: Accepts all possible ASCII keyboard entries for readable things.
     */
    public function validate_mixed(&$value, $message = "")
    {
        $success = false;
        if (preg_match('/^[0-9a-z_\-\.\,\;\:\(\)\+\=\[\]\{\}\!\@\#\$\%\^\&\*\'\ ]+$/is', $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate length of a text. Use zero ( 0 ) length to skip testing.
     */
    public function validate_length(&$value, $min_length = 0, $max_length = 0, $message = "")
    {
        $success = true;
        if (
            (!empty($min_length) && (strlen("{$value}") < $min_length)) ||
            (!empty($max_length) && (strlen("{$value}") > $max_length))
        ) {
            $success = false;
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate a regular expression pattern.
     * An attempt to make extensions for custom validations.
     */
    public function validate_regex(&$value, $pattern = '/^(.*?)$/', $message = "")
    {
        # addslashes | stripslashes, if read out from DB / Config
        /*
        echo("<br>Pattern: {$pattern} :: {$value}");
        if(preg_match('/^[a-z]{2}[\d]{3}[a-z]$/is', 'NP0982C'))
        {
            echo("<br>Pattern passed, checking");
        }
        else
        {
            echo("<br>Pattern failed, checking");
        }
        */

        $success = false;
        if (preg_match($pattern, $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate IPv4 Address
     * @url http://www.regular-expressions.info/examples.html
     */
    public function validate_ipv4(&$value, $message = "")
    {
        # /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/is
        # /^[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}$/is
        # /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/is
        # \b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)
        # \b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b
        # (?:\d{1,3}\.){3}\d{1,3}
        $success = false;
        if (preg_match("/^(?:\d{1,3}\.){3}\d{1,3}$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * Validate IPv6 Address.
     * Not implemented now. Stub only
     */
    public function validate_ipv6(&$value, $message = "")
    {
        $success = true;

        return $success;
    }

    /**
     * Validate email address
     * Has a lot of conflicts and tradeoffs
     */
    public function validate_email_single(&$value, $message = "")
    {
        $success = false;
        $email_reg = "/^[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)$/";

        if (preg_match($email_reg, $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }

    /**
     * @see http://www.addedbytes.com/php/email-address-validation/
     * @todo Fix ereg with preg_match
     */
    public function check_email_address($email = "")
    {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }

        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < count($local_array); $i++) {
            if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
            }
        }

        // Check if domain is IP. If not, it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
            $domain_array = explode(".", $email_array[1]);
            if (count($domain_array) < 2) {
                return false; // Not enough parts to domain
            }

            for ($i = 0; $i < count($domain_array); $i++) {
                if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }

    public function validate_email($email = "")
    {
        return preg_match('/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/', $email);
    }

    /**
     * Alias sections, for quick data validation (one way testing)
     */
    public function is_date($date = "")
    {
        return $this->validate_date($date, "");
    }

    /**
     * Validate date in YYYY-MM-DD format
     */
    public function validate_date(&$value, $message = "")
    {
        $success = false;
        #if(preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/is", $value))
        if (preg_match("/^[0-9]{4}\-[01][0-9]\-[0-3][0-9]$/is", $value)) {
            $success = true;
        } else {
            $this->add_error($message);
        }

        return $success;
    }
}
