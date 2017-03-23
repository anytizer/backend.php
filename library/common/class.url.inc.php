<?php
namespace common;

/**
 * Basically used to page redirections, like, list, edit a data, and go back to the original list
 * Aims to preserve the during the paginations
 * @todo Merge with header or server
 *
 * @package Common
 */
class url
{

    /**
     * This constructor is not necessary
     */
    public function __construct()
    {
        # Use this feature too wisely
        # Example:
        #   listing page lists entries to edit
        #   Editor page remembers the URI
        #   Success page of the edit will list back the referer back
        # Variable $_SESSION['REMEMBER_URI'] is re-used over multiple pages
        # Open only one page in the browser
    }

    /**
     * Assume HTTP_REFERER as the page to remember
     * Usage examples: The add/edit forms
     */
    public static function remember_referer()
    {
        $uri = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];
        $_SESSION['REMEMBER_URI'] = $uri;
    }

    /**
     * Store the current URI browsed
     * This does not care who is the referer
     * Usage examples: The listing page
     */
    public static function remember()
    {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_REFERER'];
        $_SESSION['REMEMBER_URI'] = $uri;
    }

    /**
     * Get URI from the memory
     */
    public static function last_page($url_if_empty = "", $xhtml_valid = true)
    {
        $uri = isset($_SESSION['REMEMBER_URI']) ? $_SESSION['REMEMBER_URI'] : $_SERVER['HTTP_REFERER'];

        # Immediately destroy the URI once it is used.
        # unset($_SESSION['REMEMBER_URI']);

        if ($xhtml_valid) {
            # Make XHTML valid url
            $uri = str_replace('&', '&amp;', $uri);
            $uri = str_replace('&amp;amp;', '&amp;', $uri);
        }

        return $uri;
    }
}
