<?php
namespace third;

/**
 * Converts HTML to formatted plain text                                 *
 *
 * @package Third-Party
 * @author Jon Abernathy <jon@chuggnutt.com>
 * @version 1.0.0
 * @since PHP 4.0.2
 */
class html2text
{

	/**
	 * Contains the HTML content to convert.
	 *
	 * @param string $html
	 *
	 * @access public
	 */
	private $html;

	/**
	 * Contains the converted, formatted text.
	 *
	 * @param string $text
	 *
	 * @access public
	 */
	private $text;

	/**
	 * Maximum width of the formatted text, in columns.
	 * Set this value to 0 (or less) to ignore word wrapping
	 * and not constrain text to a fixed-width column.
	 *
	 * @param integer $width
	 *
	 * @access public
	 */
	private $width = 70;

	/**
	 * List of preg* regular expression patterns to search for,
	 * used in conjunction with $replace.
	 *
	 * @param array $search
	 *
	 * @access public
	 * @see $replace
	 */
	private $search = array(
		"/\r/", // Non-legal carriage return
		"/[\n\t]+/", // Newlines and tabs
		'/[ ]{2,}/', // Runs of spaces, pre-handling
		'/<script[^>]*>.*?<\/script>/i', // <script>s -- which strip_tags supposedly has problems with
		'/<style[^>]*>.*?<\/style>/i', // <style>s -- which strip_tags supposedly has problems with
		//'/<!-- .* -->/',                         // Comments -- which strip_tags might have problem a with
		'/<h[123][^>]*>(.*?)<\/h[123]>/ie', // H1 - H3
		'/<h[456][^>]*>(.*?)<\/h[456]>/ie', // H4 - H6
		'/<p[^>]*>/i', // <P>
		'/<br[^>]*>/i', // <br>
		'/<b[^>]*>(.*?)<\/b>/ie', // <b>
		'/<strong[^>]*>(.*?)<\/strong>/ie', // <strong>
		'/<i[^>]*>(.*?)<\/i>/i', // <i>
		'/<em[^>]*>(.*?)<\/em>/i', // <em>
		'/(<ul[^>]*>|<\/ul>)/i', // <ul> and </ul>
		'/(<ol[^>]*>|<\/ol>)/i', // <ol> and </ol>
		'/<li[^>]*>(.*?)<\/li>/i', // <li> and </li>
		'/<li[^>]*>/i', // <li>
		'/<a [^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/ie',
		// <a href="">
		'/<hr[^>]*>/i', // <hr>
		'/(<table[^>]*>|<\/table>)/i', // <table> and </table>
		'/(<tr[^>]*>|<\/tr>)/i', // <tr> and </tr>
		'/<td[^>]*>(.*?)<\/td>/i', // <td> and </td>
		'/<th[^>]*>(.*?)<\/th>/ie', // <th> and </th>
		'/&(nbsp|#160);/i', // Non-breaking space
		'/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i',
		// Double quotes
		'/&(apos|rsquo|lsquo|#8216|#8217);/i', // Single quotes
		'/&gt;/i', // Greater-than
		'/&lt;/i', // Less-than
		'/&(amp|#38);/i', // Ampersand
		'/&(copy|#169);/i', // Copyright
		'/&(trade|#8482|#153);/i', // Trademark
		'/&(reg|#174);/i', // Registered
		'/&(mdash|#151|#8212);/i', // mdash
		'/&(ndash|minus|#8211|#8722);/i', // ndash
		'/&(bull|#149|#8226);/i', // Bullet
		'/&(pound|#163);/i', // Pound sign
		'/&(euro|#8364);/i', // Euro sign
		'/&[^&;]+;/i', // Unknown/unhandled entities
		'/[ ]{2,}/' // Runs of spaces, post-handling
	);

	/**
	 * List of pattern replacements corresponding to patterns searched.
	 *
	 * @param array $replace
	 *
	 * @access public
	 * @see $search
	 */
	private $replace = array(
		"", // Non-legal carriage return
		' ', // Newlines and tabs
		' ', // Runs of spaces, pre-handling
		"", // <script>s -- which strip_tags supposedly has problems with
		"", // <style>s -- which strip_tags supposedly has problems with
		//"",                                     // Comments -- which strip_tags might have problem a with
		"strtoupper(\"\n\n\\1\n\n\")", // H1 - H3
		"ucwords(\"\n\n\\1\n\n\")", // H4 - H6
		"\n\n\t", // <P>
		"\n", // <br>
		'strtoupper("\\1")', // <b>
		'strtoupper("\\1")', // <strong>
		'_\\1_', // <i>
		'_\\1_', // <em>
		"\n\n", // <ul> and </ul>
		"\n\n", // <ol> and </ol>
		"\t* \\1\n", // <li> and </li>
		"\n\t* ", // <li>
		'$this->_build_link_list("\\1", "\\2")',
		// <a href="">
		"\n-------------------------\n", // <hr>
		"\n\n", // <table> and </table>
		"\n", // <tr> and </tr>
		"\t\t\\1\n", // <td> and </td>
		"strtoupper(\"\t\t\\1\n\")", // <th> and </th>
		' ', // Non-breaking space
		'"', // Double quotes
		"'", // Single quotes
		'>',
		'<',
		'&',
		'(c)',
		'(tm)',
		'(R)',
		'--',
		'-',
		'*',
		'�',
		'EUR', // Euro sign. � ?
		"", // Unknown/unhandled entities
		' ' // Runs of spaces, post-handling
	);

	/**
	 * Contains a list of HTML tags to allow in the resulting text.
	 *
	 * @param string $allowed_tags
	 *
	 * @access public
	 * @see set_allowed_tags()
	 */
	private $allowed_tags = "";

	/**
	 * Contains the base URL that relative links should resolve to.
	 *
	 * @param string $url
	 *
	 * @access public
	 */
	private $url;

	/**
	 * Indicates whether content in the $html variable has been converted yet.
	 *
	 * @param boolean $_converted
	 *
	 * @access private
	 * @see $html, $text
	 */
	private $_converted = false;

	/**
	 * Contains URL addresses from links to be rendered in plain text.
	 *
	 * @param string $_link_list
	 *
	 * @access private
	 * @see _build_link_list()
	 */
	private $_link_list = "";

	/**
	 * Number of valid links detected in the text, used for plain text
	 * display (rendered similar to footnotes).
	 *
	 * @param integer $_link_count
	 *
	 * @access private
	 * @see _build_link_list()
	 */
	private $_link_count = 0;
	
	/**
	 * @todo Fix this class file
	 */
	public function __construct()
	{
	}

	/**
	 * Constructor.
	 * If the HTML source string (or file) is supplied, the class
	 * will instantiate with that source propagated, all that has
	 * to be done it to call get_text().
	 *
	 * @param string  $source HTML content
	 * @param boolean $from_file Indicates $source is a file to pull content from
	 *
	 * @access public
	 * @return void
	 */
	public function process($source = "", $from_file = false)
	{
		if(!empty($source))
		{
			$this->set_html($source, $from_file);
		}
		$this->set_base_url();
	}

	/**
	 * Loads source HTML into memory, either from $source string or a file.
	 *
	 * @param string  $source HTML content
	 * @param boolean $from_file Indicates $source is a file to pull content from
	 *
	 * @access public
	 * @return void
	 */
	public function set_html($source, $from_file = false)
	{
		$this->html = $source;

		if($from_file && file_exists($source))
		{
			$fp = fopen($source, 'r');
			$this->html = fread($fp, filesize($source));
			fclose($fp);
		}

		$this->_converted = false;
	}

	/**
	 * Returns the text, converted from HTML.
	 *
	 * @access public
	 * @return string
	 */
	public function get_text()
	{
		if(!$this->_converted)
		{
			$this->_convert();
		}

		return $this->text;
	}

	/**
	 * Prints the text, converted from HTML.
	 *
	 * @access public
	 * @return void
	 */
	public function print_text()
	{
		print $this->get_text();
	}

	/**
	 * Alias to print_text(), operates identically.
	 *
	 * @access public
	 * @return void
	 * @see print_text()
	 */
	public function p()
	{
		print $this->get_text();
	}

	/**
	 * Sets the allowed HTML tags to pass through to the resulting text.
	 * Tags should be in the form "<p>", with no corresponding closing tag.
	 *
	 * @access public
	 * @return void
	 */
	public function set_allowed_tags($allowed_tags = "")
	{
		if(!empty($allowed_tags))
		{
			$this->allowed_tags = $allowed_tags;
		}
	}

	/**
	 * Sets a base URL to handle relative links.
	 *
	 * @access public
	 * @return void
	 */
	public function set_base_url($url = "")
	{
		if(empty($url))
		{
			if(!empty($_SERVER['HTTP_HOST']))
			{
				$this->url = 'http://' . $_SERVER['HTTP_HOST'];
			}
			else
			{
				$this->url = "";
			}
		}
		else
		{
			// Strip any trailing slashes for consistency (relative
			// URLs may already start with a slash like "/file.html")
			if(substr($url, -1) == '/')
			{
				$url = substr($url, 0, -1);
			}
			$this->url = $url;
		}
	}

	/**
	 * Workhorse function that does actual conversion.
	 * First performs custom tag replacement specified by $search and
	 * $replace arrays. Then strips any remaining HTML tags, reduces whitespace
	 * and newlines to a readable format, and word wraps the text to
	 * $width characters.
	 *
	 * @access private
	 * @return void
	 */
	public function _convert()
	{
		// Variables used for building the link list
		$this->_link_count = 0;
		$this->_link_list = "";

		$text = trim(stripslashes($this->html));

		// Run our defined search-and-replace
		$text = preg_replace($this->search, $this->replace, $text);

		// Strip any other HTML tags
		$text = strip_tags($text, $this->allowed_tags);

		// Bring down number of empty lines to 2 max
		$text = preg_replace("/\n\s+\n/", "\n\n", $text);
		$text = preg_replace("/[\n]{3,}/", "\n\n", $text);

		// Add link list
		if(!empty($this->_link_list))
		{
			$text .= "\n\nLinks:\n------\n" . $this->_link_list;
		}

		// Wrap the text to a readable format
		// for PHP versions >= 4.0.2. Default width is 75
		// If width is 0 or less, don't wrap the text.
		if($this->width > 0)
		{
			$text = wordwrap($text, $this->width);
		}

		$this->text = $text;

		$this->_converted = true;
	}

	/**
	 * Helper function called by preg_replace() on link replacement.
	 * Maintains an internal list of links to be displayed at the end of the
	 * text, with numeric indices to the original point in the text they
	 * appeared. Also makes an effort at identifying and handling absolute
	 * and relative links.
	 *
	 * @param string $link URL of the link
	 * @param string $display Part of the text to associate number with
	 *
	 * @access private
	 * @return string
	 */
	public function _build_link_list($link, $display)
	{
		if(substr($link, 0, 7) == 'http://' || substr($link, 0, 8) == 'https://' ||
			substr($link, 0, 7) == 'mailto:'
		)
		{
			$this->_link_count++;
			$this->_link_list .= "[" . $this->_link_count . "] $link\n";
			$additional = ' [' . $this->_link_count . ']';
		}
		elseif(substr($link, 0, 11) == 'javascript:')
		{
			// Don't count the link; ignore it
			$additional = "";
			// what about href="#anchor" ?
		}
		else
		{
			$this->_link_count++;
			$this->_link_list .= "[" . $this->_link_count . "] " . $this->url;
			if(substr($link, 0, 1) != '/')
			{
				$this->_link_list .= '/';
			}
			$this->_link_list .= "$link\n";
			$additional = ' [' . $this->_link_count . ']';
		}

		return $display . $additional;
	}
}
