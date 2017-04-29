<?php
namespace third;

/**
 * Connects to bitly.com to generate short URLs.
 *
 * @package Common
 *
 * 405: Method Not Allowed
 * @param $token curl -u "username:password" -X POST "https://api-ssl.bitly.com/oauth/access_token"
 *
 * @link http://dev.bitly.com/authentication.html#apikey
 * @tutorial
 *    $url = 'http://your.domain.tld/';
 *    $token = 'YOURBITLEYTOKEN';
 *    $bitly = new bitly($token);
 *    $bitly_url = $bitly->shorten($url);
 *    echo $bitly_url;
 */
class bitly
{
    private $token;
    private $bitly_url = 'https://api-ssl.bitly.com/v3/shorten';

    /**
     * Initiate the class with tokens stored separately
     */
    public function __construct($token = "")
    {
        $this->token = $token;
    }

    /**
     * Generate a short URL in bit.ly server
     *
     * @param string $url
     *
     * @return string URL
     */
    public function shorten($url = "")
    {
        $bitly_url = "";

        $url_encoded = rawurlencode($url);
        $bitly_request_url = "{$this->bitly_url}?access_token={$this->token}&longUrl={$url_encoded}";

        /**
         * @todo Use cURL class rather
         */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $bitly_request_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);
        if (property_exists($json, 'status_code')) {
            if ($json->status_code == '200') {
                $bitly_url = $json->data->url;
            }
        }

        return $bitly_url;
    }
}

/*
# Response (Contents are modified in the below text)

# Raw JSON

{ "status_code": 200, "status_txt": "OK", "data": { "long_url": "http:\/\/your.domain.tld\/", "url": "http:\/\/bit.ly\/aTj2Ya", "hash": "aTj2Ya", "global_hash": "aTj2Ya", "new_hash": 0 } }

# Decoded JSON
print_r($json);
stdClass Object
(
    [status_code] => 200
    [status_txt] => OK
    [data] => stdClass Object
        (
            [long_url] => http://your.domain.tld/
            [url] => http://bit.ly/aTj2Ya
            [hash] => aTj2Ya
            [global_hash] => aTj2Ya
            [new_hash] => 0
        )

)
*/
