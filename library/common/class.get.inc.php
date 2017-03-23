<?php
namespace common;

/**
 * Accept default $_GET parameters, append other arrays, and remake $_GET
 *
 * @package Common
 */
class get
{
    public $GET;

    /**
     * Initialise with a default array
     */
    public function __construct($get_array = array())
    {
        if ($get_array) {
            $this->GET = $get_array;
        } else {
            $this->GET = $_GET;
        }
    }

    /**
     * Build the valid URL
     *
     * @return string
     */
    public function url()
    {
        $string = "";
        $counter = 0;
        foreach ($this->GET as $k => $v) {
            if ($counter > 0) {
                $string .= "&";
            }
            ++$counter;
            $v = urlencode($v);
            $string .= "{$k}={$v}";
        }

        return $string;
    }

    /**
     * Force a new index in the queue
     */
    public function add($key, $value)
    {
        $this->GET[$key] = $value;
    }

    /**
     * Remove all indices
     *
     * @return bool
     */
    public function clean()
    {
        $this->GET = array();

        return false;
    }

    /**
     * Remove indices selectively
     *
     * @param string $index
     *
     * @return bool
     */
    public function no_get($index = "")
    {
        $success = false;
        if (isset($this->GET[$index])) {
            unset($this->GET[$index]);
            $success = true;
        }

        return $success;
    }
}

