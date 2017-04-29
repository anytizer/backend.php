<?php
namespace common;

/**
 * Array map operations.
 * All the functions defined here are primarily meant for the array mapping operations.
 *
 * @package Common
 */
class array_operation
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Manipulate an array with a specific function in this class
     *
     * @param string $ao_function
     * @param array $array
     *
     * @return array
     */
    public function operate($ao_function = "", &$array = array())
    {
        if (!is_array($array)) {
            return $array;
        }

        $new_array = array();
        if (method_exists($this, $ao_function) && is_array($array)) {
            # Give priorities to the methods of this own class
            $new_array = array_map(array(&$this, $ao_function), $array);
        } elseif (function_exists($ao_function)) {
            # Process native php functions, or user defined free/external functions
            $new_array = array_map($ao_function, $array);
        } else {
            # Do not process anything. Simply return the original data.
            $new_array = $array;
        }

        return $new_array;
    } # operate()

    /**
     * Encode URL
     *
     * @param string $value
     *
     * @return string
     */
    public function url_encode($value = "")
    {
        return urlencode($value);
    } # url_encode()

    /**
     * Encode a value within in the <td> tags
     * Helpful for creating HTML Table Columns
     *
     * @param string $value
     *
     * @return string
     */
    public function td($value = "")
    {
        return "<td>{$value}</td>";
    } # td()

    /**
     * Wrap HTML (TDs) within the <tr> tags
     * Helpful for creating HTML Table Rows
     *
     * @param string $value
     *
     * @return string
     */
    public function tr($value = "")
    {
        return "<tr>{$value}</tr>";
    } # tr()

    /**
     * Wrap a text within the <li>...</li> tags
     *
     * @param string $value
     *
     * @return string
     */
    public function li($value = "")
    {
        return "<li>{$value}</li>";
    } # li()

        /**
     * Alias of quote()
     *
     * @param string $value
     *
     * @return string
     */
    public function quotes($value = "")
    {
        return $this->quote($value);
    } # quote()

/**
     * Quotes variable to make it safe - Tries to prevent SQL Injection
     * Useful in calling within SQL statements: Use no quotes!
     * Support to magic quotes gpc lookup removed
     *
     * @param string $value
     *
     * @return string
     */
    public function quote($value = "")
    {
        $v = "'" . addslashes($value) . "'";

        return $v;
    }

    /**
     * Prevent reading enquoted text: Alias of stripslashes
     *
     * @uses Formatting - Add the slashes, etc.
     *
     * @param string $text Text to format
     *
     * @return string
     */
    public function no_slash($text = "")
    {
        $no_slashes = stripslashes($text);

        return $no_slashes;
    } # no_slash()

    /**
     * Prevent writing enquoted text: Alias of addslashes
     *
     * @uses Formatting - Add the slashes, etc.
     *
     * @param $text string Text to format
     *
     * @return string Unformatted string
     */
    public function slash($text = "")
    {
        $slashesd = addslashes($text);

        return $slashesd;
    } # slash()

    /**
     * HTML to clean text: Alias of strip_tags
     *
     * @param string $text
     *
     * @return string
     */
    public function no_tags($text = "")
    {
        $clean_text = strip_tags($text);

        return $clean_text;
    }

    /**
     * Trim/Clean the text: Alias of trip
     *
     * @param string $text
     *
     * @return string
     */
    public function clean($text = "")
    {
        return trim($text);
    } # clean()

    /**
     * Extracts the value of &lt;TITLE&gt; tag
     *
     * @todo: where is this used?
     *
     * @param string $html
     *
     * @return array
     */
    public function title($html = "")
    {
        $pattern = '/<title>(.*?)\<\/title\>/i';
        $findings = array();
        preg_match_all($pattern, $html, $findings, PREG_SET_ORDER);

        return $findings;
    }

    /**
     * Explode a line (excel copied) with tab character
     * Useful in TSV parser
     *
     * @param string $line
     *
     * @return array
     */
    public function explode_tabs($line = "")
    {
        $columns = explode("\t", $line);

        return $columns;
    }

    /**
     * Removes single quotes, double quotes and ticks
     *
     * @param string $word
     *
     * @return mixed|string
     */
    public function remove_quotes($word = "")
    {
        $new_word = $word;
        $new_word = str_replace('"', "", $new_word);
        $new_word = str_replace("'", "", $new_word);
        $new_word = str_replace("`", "", $new_word); # Optional
        return $new_word;
    }

    /**
     * Bind a word with single quotes
     *
     * @param string $word
     *
     * @return string
     */
    public function wrap_quotes_single($word = "")
    {
        $bound_word = $word;

        # Optional
        #$bound_word = str_replace("'", "'", $bound_word);

        $bound_word = "'{$bound_word}'";

        return $bound_word;
    }

    /**
     * Bind a word with single quotes
     *
     * @param string $word
     *
     * @return string
     */
    public function wrap_quotes_double($word = "")
    {
        $bound_word = $word;
        $bound_word = "\"{$bound_word}\"";

        return $bound_word;
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function tick($word = "")
    {
        return $this->wrap_ticks($word);
    }

    /**
     * Bind a word with tick ( ` ). Useful for making column names
     *
     * @param string $word
     *
     * @return string
     */
    public function wrap_ticks($word = "")
    {
        $bound_word = "`{$word}`";

        return $bound_word;
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function ticks($word = "")
    {
        return $this->wrap_ticks($word);
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function wrap_tick($word = "")
    {
        return $this->wrap_ticks($word);
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function brackets($word = "")
    {
        return $this->wrap_braces($word);
    }

    /**
     * Bind a word with braces. Useful in creating multiple inserts via SQL.
     *
     * @param string $word
     *
     * @return string
     */
    public function wrap_braces($word = "")
    {
        $bound_word = "({$word})";

        return $bound_word;
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function bracket($word = "")
    {
        return $this->wrap_braces($word);
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public function braces($word = "")
    {
        return $this->wrap_braces($word);
    }

    /**
     * Assigns a key/value pair from arrays of keys and values.
     *
     * @param array $column_names
     * @param array $values
     *
     * @return array
     */
    public function assign_columns($column_names = array(), $values = array())
    {
        $assign = array_map(array(&$this, '_assign_key_value'), $column_names, $values);

        return $assign;
    }

    /**
     * Extracts the numbers only from a string
     *
     * @see \common\tools::numeric()
     *
     * @param string $string
     *
     * @return string
     */
    private function numeric($string = "")
    {
        $digits = preg_split('/[^\d]+/is', $string, -1);

        return implode("", $digits);
    }

    /**
     * Private handler to create a key value assignments.
     * Useful in creating UPDATE, INSERT SQLs or other PHP Variable Processing
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    private function _assign_key_value($key = "", $value = "")
    {
        $assign = "{$key}={$value}";

        return $assign;
    }
}
