<?php
namespace common;

/**
 * Extracts the initial letters of a string's words
 */
class initials
{
    public $first;

    /**
     * Begin with determining how many characters to extract.
     */
    public function __construct($first = 3)
    {
        $this->first = $first;
    }

    /**
     * Calculate the initials
     */
    public function get($string = "")
    {
        $words = explode(" ", $string);
        $letters = array_map(array(&$this, 'letter'), $words);

        $phrase = implode("", $letters);

        return $phrase;
    }

    /**
     * Read an initial letter of a name's word
     */
    private function letter($word = "")
    {
        $letters = strtolower(substr($word, 0, $this->first));

        return $letters;
    }
}

