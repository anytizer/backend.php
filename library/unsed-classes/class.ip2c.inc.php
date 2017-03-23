<?php

/**
 * Reads the IP to Country Database.
 * Uses the IP2C database from MaxMinds, using its own PHP Library.
 * @todo GeoIP does not exist
 */
class ip2c
{
    private $gi; # Pointer to GeoIP data file.
    private $db; # MySQL

    /**
     * Open the flat database file on the start up.
     */
    public function __construct()
    {
        $location = __THIRD_PARTIES__ . '/GeoIP';
        require_once($location . '/geoip.inc');

        $this->gi = geoip_open($location . '/GeoIP.dat', GEOIP_STANDARD);
        $this->db = new \common\mysql();
    }

    /**
     * Reads our own country ID based on CC2
     */
    public function country_id($ip = '0.0.0.0') # ($cc='XX')
    {
        $cc = $this->cc($ip);
        $cc2id_sql = "
SELECT
	countries_id id
FROM countries
WHERE
	countries_iso_code_2='{$cc}'
;";
        if ($country = $this->db->row($cc2id_sql)) {
        } else {
            $country['id'] = 0;
        }

        return $country['id'];
    }

    /**
     * Read the country code (CC2)
     */
    public function cc($ip = '0.0.0.0')
    {
        $ip = ($ip != '0.0.0.0') ? $ip : $_SERVER['REMOTE_ADDR'];
        $cc = geoip_country_code_by_addr($this->gi, $ip);
        $cc = (!$cc) ? 'XX' : $cc;

        #echo("IP: {$ip} = {$cc}");

        return $cc;
    }

    /**
     * Reads our own country Name based on CC2
     */
    public function country_name($ip = '0.0.0.0') # ($cc='XX')
    {
        $cc = $this->cc($ip);
        $cc2id_sql = "
SELECT
	countries_name cn
FROM countries
WHERE
	countries_iso_code_2='{$cc}'
;";
        if ($country = $this->db->row($cc2id_sql)) {
        } else {
            $country['cn'] = 'USA';
        }

        return $country['cn'];
    }

    /**
     * Close the reader
     */
    public function __destruct()
    {
        #geoip_close($this->gi);
    }
}
