<?php
namespace common;

/**
 * Read a name string and break it into First name, Middle name and Last name.
 * Supports many words as a name.
 */
class names
{
    /**
     * Split full name string into words as first, medium and last name.
     *
     * @param $full_name string
     *
     * @return array
     */
    public function read_name($full_name = "", $fix_case = false)
    {
        $names = explode(" ", $full_name);

        $name = array();
        $name["F"] = "";
        $name["M"] = "";
        $name["L"] = "";
        # Assigning these empty values makes sure that each of the three parts exists.

        $words = count($names);
        switch ($words) {
            case 0:
                break;
            case 1:
                $name["F"] = $names[0];
                break;
            case 2:
                $name["F"] = $names[0];
                $name["L"] = $names[1];
                break;
            case 3:
                $name["F"] = $names[0];
                $name["M"] = $names[1];
                $name["L"] = $names[2];
                break;
            default:
                # Case of 4 or more than 4 words in the name

                # First and last names are predictable
                $name["F"] = $names[0];
                $name["L"] = $names[$words - 1];

                # Now consider the words between
                $name_temp = $names;
                unset($name_temp[0]);
                unset($name_temp[$words - 1]);
                $name["M"] = implode(" ", $name_temp);
				
				break;
        }

        if ($fix_case === true) {
            $name = array_map("strtolower", $name);
            $name = array_map("ucfirst", $name);
        }

        return $name;
    }
}
