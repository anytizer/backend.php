<?php
namespace common;

/**
 * Gives the ordinality of a number.
 */
class ordinal
{
    /**
     * Initiates a dynamic constructor
     */
    function __construct()
    {
    } # __construct()

    /**
     * Calculates the ordinality of a given number.
     *
     * @param integer number whose ordinality needs to be calculated.
     *
     * @return string ordinality word of the number.
     */
    function ordinality($number = 0)
    {
        $number += 0; # safety against hack-attempts
        $ordinals = array(
            0 => 'th',
            1 => 'st',
            2 => 'nd',
            3 => 'rd',
            11 => 'th',
            12 => 'th',
            13 => 'th'
        );

        $ordinality = "";
        if (array_key_exists($number, $ordinals)) {
            $ordinality = $ordinals[$number];
        } else {
            $number %= 10;
            if (array_key_exists($number, $ordinals)) {
                $ordinality = $ordinals[$number];
            } else {
                $ordinality = 'th';
            }
        }

        return $ordinality;
    } # ordinality()

} # ordinal 

/**
 * # Case study:
 * zeroth first second third fourth fifth sixth eighth ninth tenth eleventh
 * 0th
 * 1st 2nd 3rd 4th 5th 6th 7th 8th 9th 10th
 * 11th 12th 13th ... 20th
 * 21st 22nd 23rd 24th ...
 */
