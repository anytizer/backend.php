<?php
namespace abstracts;

/**
 * Interface for whois checker
 *
 * Class whois_base
 * @package abstracts
 */
abstract class whois_base
{
    protected $response_html = "";
    protected $is_registered = false;
    protected $expires_on = 'N/A';
}
