<?php
namespace third;

    /**
     * @todo Find the usage or remove
     */
# http://www.darkcoding.net/project-files/gencc.tar.gz
# http://www.darkcoding.net/

    /*
    PHP credit card number generator
    Copyright (C) 2006 Graham King graham@darkcoding.net

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
    */

/**
 * PHP credit card number generator
 *
 * @package Third-Party
 */
class creditcard
{
    /*
    'prefix' is the start of the CC number as a string, any number of digits.
    'length' is the length of the CC number to generate. Typically 13 or 16
    */
    public function credit_card_number($prefixList, $length, $howMany)
    {

        for ($i = 0; $i < $howMany; $i++) {

            $ccnumber = $prefixList[array_rand($prefixList)];
            $result[] = $this->completed_number($ccnumber, $length);
        }

        return $result;
    }

    public function completed_number($prefix, $length)
    {

        $ccnumber = $prefix;

        # generate digits

        while (strlen($ccnumber) < ($length - 1)) {
            $ccnumber .= mt_rand(0, 9);
        }

        # Calculate sum

        $sum = 0;
        $pos = 0;

        $reversedCCnumber = strrev($ccnumber);

        while ($pos < $length - 1) {

            $odd = $reversedCCnumber[$pos] * 2;
            if ($odd > 9) {
                $odd -= 9;
            }

            $sum += $odd;

            if ($pos != ($length - 2)) {

                $sum += $reversedCCnumber[$pos + 1];
            }
            $pos += 2;
        }

        # Calculate check digit

        $checkdigit = ((floor($sum / 10) + 1) * 10 - $sum) % 10;
        $ccnumber .= $checkdigit;

        return $ccnumber;
    }
}