<?php
namespace common;

/**
 * Converts among various date formats
 *
 * @package Common
 */
class dater
{
    private $date_input = "";

    # Parsed date formats
    private $yyyymmdd = "";
    private $mmddyyyy = "";

    # While returning a date
    private $separator = '/';

    /**
     * @todo Fix this class file
     */
    public function __construct()
    {
    }

    /**
     * @param string $date_input
     */
    public function convert($date_input = "")
    {
        $date_input = preg_replace('/[^0-9\/\-]/', "", $date_input);
        $date_input = preg_replace('/[^0-9]+/', '-', $date_input);
        if ($date_input) {
            $this->date_input = $date_input;
            $this->process_date();
        } else {
            throw new \Exception("Date format not supported: {$date_input}");
        }
    }

    /**
     *
     */
    private function process_date()
    {
        $data = array();
        switch (1) {
            case preg_match('/^([\d]{4})\-([\d]{2})\-([\d]{2})$/', $this->date_input, $data): # YYYY-MM-DD
                #echo 'YYYY-MM-DD';
                # No touch
                $this->yyyymmdd = "{$data[1]}-$data[2]-$data[3]";
                $this->mmddyyyy = "{$data[2]}-$data[3]-$data[1]";
                break;
            #case # DD-MM-YY
            # what to do or how to predict this?
            # break;
            case preg_match('/^([\d]{2})\-([\d]{2})\-([\d]{4})$/', $this->date_input, $data): # DD-MM-YYYY
                #echo 'DD-MM-YYYY matched';
                $this->yyyymmdd = "{$data[3]}-$data[1]-$data[2]";
                $this->mmddyyyy = "{$data[2]}-$data[1]-$data[3]";
#    [0] => 12-12-1981
#    [1] => 12
#    [2] => 12
#    [3] => 1981

                break;
            default:
                throw new \Exception('what?');
            # Error!
        }
    }

    /**
     * @return mixed
     */
    public function yyyymmdd()
    {
        return preg_replace('/\-/', $this->separator, $this->yyyymmdd);
    }

    /**
     * @return mixed
     */
    public function mmddyyyy()
    {
        return preg_replace('/\-/', $this->separator, $this->mmddyyyy);
    }
}
