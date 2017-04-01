<?php
namespace common;

/**
 * Zen-cart compatible password management
 *
 * @package Common
 */
class password
{
    private $salt_length = 5;

    /**
     * Begin password
     */
    public function __construct($salt_length = 0)
    {
        if ($salt_length = (int)$salt_length) {
            $this->salt_length = $salt_length;
        }
    }

    public function random_password(): string
    {
        $min = 10;
        $max = 20;

        $length = $this->random($min, $max);
        $random_password = $this->random_string($length);

        return $random_password;
    }

    public function random_salt(): string
    {
        $min = 5;
        $max = 10;

        $length = $this->random($min, $max);
        $random_password = $this->random_string($length);

        return $random_password;
    }

    private function random_string(int $length): string
    {
        $random_password = random_bytes($length);

        return $random_password;
    }

    /**
     * Exact copy of old zencart (front end password encrypt)
     */
    public function encrypt_password($plain = ""): string
    {
        $password = "";
        for ($i = 0; $i < 10; $i++) {
            $password .= $this->random();
        }

        $auto_salt = substr(md5($password), 0, $this->salt_length);
        $password = md5($salt . $plain) . ':' . $auto_salt;

        return $password;
    }

    /**
     * Return a random numeric value
     */
    private function random(int $min = null, int $max = null): int
    {
        mt_srand((double)microtime() * 1000000);
		$seeded = true;

        if (isset($min) && isset($max)) {
            if ($min >= $max) {
                return $min;
            } else {
                return mt_rand($min, $max);
            }
        } else {
            return mt_rand();
        }
    }

    /**
     * Validates a plain text password with an encrpyted password
     */
    public function validate_password($plain = "", $encrypted = ""): bool
    {
        # if password match fails, you might have supplied encrypted password instead of plain password.
        #die("Plain: {$plain}, Encrypted Match: {$encrypted}");
        if ($this->not_null($plain) && $this->not_null($encrypted)) {
            # split apart the hash / salt
            $stack = explode(':', $encrypted);

            # We need exctly 2 parts in the password.
            if (count($stack) != 2) {
                return false;
            }

            # The salt length must be same.
            if (strlen($stack[1]) != $this->salt_length) {
                return false;
            }

            # Yes, the real password match is here.
            if (md5($stack[1] . $plain) == $stack[0]) {
                return true;
            }
        }

        return false;
    }

    /**
     * A modified copy of old zencarrt password checker
	 * @see https://github.com/zencart/zencart
	 * @see includes\library\ircmaxell\password_compat\lib\password.php
	 * @see zen_not_null includes\functions\functions_general.php
     */
    private function not_null($value): bool
    {
        if (is_array($value)) {
            if (count($value) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            /**
             * @todo Some smelly code
             */
            if ((is_string($value) || is_int($value)) && ($value != "") && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
