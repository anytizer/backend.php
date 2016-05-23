<?php
namespace abstracts;

/**
 * Interface for whois checker
 *
 * @package Interfaces
 */
abstract class whois_base
{
	protected $response_html = '';
	protected $is_registered = false;
	protected $expires_on = 'N/A';
}
