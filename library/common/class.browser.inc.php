<?php
namespace common;

/**
 * Browser detection code.
 * In intranet applications, we can FORCE a rule to use a particular browser.
 *
 * @package Common
 */
class browser
{
    public $is_allowed;
    private $browsers_allowed;
    private $browser_detected;
    private $browser_qualified; # Read this flag...

    public function __construct()
    {
        /**
         * Put a list of browsers and their versions required.
         * Remove these browsers in the code here, or put them in remarks.
         * Disallowed browsers should NOT be typed in.
         */
        $this->browsers_allowed = array();
        $this->browsers_allowed[] = array('Mozilla', '5');
        $this->browsers_allowed[] = array('Firefox', '3');
        $this->browsers_allowed[] = array('Opera', '9');
        $this->browsers_allowed[] = array('Safari', '7');

        $this->browser_detected = $this->detect_browser();

        $this->is_allowed();
    }

    /**
     * Finds out what client/browser header is used
     *
     * @return array
     */
    private function detect_browser()
    {
        $result = array();
        # $_SERVER['HTTP_USER_AGENT'] has a definite value under this framework.
        preg_match_all('/([a-zA-Z]+)\/([0-9]+\.[0-9]+)/', $_SERVER['HTTP_USER_AGENT'], $result, PREG_SET_ORDER);

        $length = count($result);
        for ($i = 0; $i < $length; ++$i) {
            # Fix the version, optional
            $result[$i][2] = floor($result[$i][2]);

            unset($result[$i][0]);
            $result[$i] = array_values($result[$i]);
        }

        return $result;
    }

    private function is_allowed()
    {
        $success = false;
        foreach ($this->browser_detected as $d => $bd) {
            foreach ($this->browsers_allowed as $a => $ba) {
                if ($bd[0] == $ba[0]) # Compare names
                {
                    # Browser: $bd[0]
                    # Version: $bd[1]

                    # Record the first matched browser name
                    $this->browser_qualified = array($bd[0], $bd[1]);

                    $success = true;
                    break; # inner loop
                }
            }
            if ($success === true) {
                break; # outer loop
            }
        }
        $this->is_allowed = $success;

        return $success;
    }

    /**
     * Name a first matched browser
     */
    public function browser_name()
    {
        $name = !empty($this->browser_qualified[0]) ? strtolower($this->browser_qualified[0]) : 'unknown';

        return $name;
    }

    /**
     * Gets the current browser's version
     */
    public function browser_version()
    {
        $version = "";

        return $version;
    }
}

