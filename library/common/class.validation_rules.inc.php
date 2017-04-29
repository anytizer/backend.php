<?php
namespace common;

/**
 * Generic all kinds of validations, used in server side validation process.
 *
 * Class validation_rules
 * @package common
 */
class validation_rules
{
    private $value;

    public function __construct($value)
    {
        $this->value = trim($value);
    }

    /**
     * Converts a user data into proper format
     * @example $clean = (new validation_rules($dirty))->postalcode;
     * @example $clean = (new validation_rules($dirty))->fullname;
     * @example $clean = (new validation_rules($dirty))->email;
     * @example $clean = (new validation_rules($dirty))->money;
     * @example $clean = (new validation_rules($dirty))->phone;
     * @example $clean = (new validation_rules($dirty))->digits;
     *
     * @param string $name
     * @return mixed|string
     */
    public function __get(string $name)
    {
        $output = "";
        $method = "_rule_{$name}";

        if(method_exists($this, $method))
        {
            $output = call_user_func(array($this, $method), null);
        }

        return $output;
    }

    /**
     * Upper case
     * @return string
     */
    private function _rule_upper()
    {
        return strtoupper($this->value);
    }

    /**
     * Lower case
     * @return string
     */
    private function _rule_lower()
    {
        return strtolower($this->value);
    }

    /**
     * Digits only
     * @return mixed
     */
    private function _rule_digits()
    {
        $digits = preg_replace("/[^0-9]/is", "", $this->value);
        return $digits;
    }

    /**
     * Full Name in plain English
     * @todo Handle cliches', umlauts, utf, unicodes
     *
     * @return string
     */
    private function _rule_fullname(): string
    {
        $fullname = strtolower($this->value);
        $fullname = preg_replace("/[^\\.\\-\\ a-zA-Z]/is", "", $fullname);
        $fullname = trim($fullname);
        $fullname = preg_replace("/\\s+/is", " ", $fullname); // remove spaces
        $names = preg_split("/[\\ ]/is", $fullname); // wordify
        $names = array_map("ucfirst", $names); // ucfirst
        $fullname = implode(" ", $names); // back

        return $fullname;
    }

    /**
     * Phone Number
     * @return mixed|string
     */
    private function _rule_phone()
    {
        $phonenuber = $this->value;

        $phonenuber = preg_replace("/[^\\+0-9]/is", "", $phonenuber);
        if(strlen($phonenuber))
        {
            $has_plus_sign = $phonenuber[0]=="+"; // first is +
            $phonenuber = ($has_plus_sign?"+":"").preg_replace("/[^0-9]/is", "", $phonenuber);
        }

        return $phonenuber;
    }

    /**
     * @todo Convert to Double as well
     * @todo Use Money Format
     * @todo Prevent digits change in last postion - while fixing/rounding
     * @see http://php.net/manual/en/function.money-format.php
     * @see http://floating-point-gui.de/languages/php/
     * @return float
     */
    private function _rule_money(): float
    {
        $money = $this->value;

        $money = (float)preg_replace("/[^0-9\\.]/is", "", $money);
        // $money = round($money, 2); // works, but likely to change the last digits
        $money = number_format($money, 2, ".", ""); // has too many floating points
        // $money = preg_replace("/([0-9]{1,})\\.([0-9]{2})(.*?)$/is", "\$1.\$2", $money);

        // Auto parsed to float due to return type typed in as hint
        return $money;
    }

    /**
     * Email format
     * @return string
     */
    private function _rule_email(): string
    {
        $email = $this->value;

        $email = preg_replace("/[\\s]/is", "", $email);
        $email = preg_replace("/[^\\@a-zA-Z0-9\\.\\-\\_]/is", "", $email);

        return $email;
    }

    /**
     * Postal Code
     * @return string
     */
    private function _rule_postalcode(): string
    {
        $postalcode = strtoupper($this->value);
        if(strlen($postalcode))
        {
            $postalcode = preg_replace("/[^A-Z0-9]/is", "", $postalcode);
            $postalcode = preg_replace("/^([A-Z0-9]{3})?(.*?)$/", "\$1 \$2", $postalcode);
        }

        return $postalcode;
    }

    private function _rule_yn()
    {
        $yn = "N";

        $yesno = strtoupper($this->value);
        switch($yesno)
        {
            case "Y":
            case "YES":
                $yn = "Y";
                break;
            case "N":
            case "NO":
                $yn = "N";
                break;
            default:
                // error
                break;
        }

        return $yn;
    }
}