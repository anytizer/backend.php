<?php
namespace third;

/**
 * Internic checker
 */
class whois_internic
    extends whois_base
    implements whois
{
    public function __construct($domain = "", $pieces = array())
    {
        $checker_url = 'http://reports.internic.net/cgi/whois?type=domain&whois_nic=%s';
        $url = sprintf($checker_url, $domain);

        $this->response_html = file_get_contents($url);
        #$this->response_html = file_get_contents('whois.txt');
    }

    /**
     * Find out whether the domain was registered or not
     */
    public function is_registered($domain = "")
    {
        $data = array();
        preg_match('/Expiration Date: (.*?)[\r|\n]+/is', $this->response_html, $data);
        #print_r($data);

        #$this->is_registed = $this->is_registered();
        if ($this->is_registed = isset($data[1])) {
            $this->expires_on = $data[1];
        }

        return $this->is_registed;
    }
}
