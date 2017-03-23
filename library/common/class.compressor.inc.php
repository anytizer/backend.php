<?php
namespace common;

/**
 * CSS and Javascript compressor
 *
 * @package Common
 */
class compressor
{
    public $compressor_contents = "";
    public $compressor_size = "";
    public $files = array();
    public $directory_cached = "";
    public $directory_protected = "";
    public $content_type = "";

    /**
     * Constructor establishes the variables that can not be (null or blank).
     */
    public function __construct()
    {
        $this->compressor_contents = "";
        $this->compressor_size = 0;
        $this->files = array();

        $this->directory_cached = 'cached';
        $this->directory_protected = 'protected';
        $this->content_type = 'text/plain'; # For header output
    }

    /**
     * Read out the file contents.
     * Supports reading from protected directories too. Just change the diretory.
     * compression: javascript / css
     * Examples: $files_list='snippet1.txt|snippet2.txt'
     *
     * @param string $files_list
     * @param string $compression_type
     */
    public function gather_files($files_list = 'snippet1.txt|snippet2.txt', $compression_type = 'javascript')
    {
        $file_details = array();
        $this->compressor_contents = ""; # Reset it first.
        $files = explode('|', $files_list); # Were there multiple files requested?
        #\common\stopper::debug($files, false); \common\stopper::message();
        foreach ($files as $i => $file) {
            if (!$file) {
                continue;
            }
            $compressor_file = $this->directory_protected . '/' . $file; # Ran from the /js, /css directory! Or, even from protected directories
            if (file_exists($compressor_file)) {
                $this->compressor_contents .= file_get_contents($compressor_file);
                $this->files[] = $compressor_file;

                ++$i;
                $file_details['name'][$i] = $compressor_file;
                $file_details['time'][$i] = filemtime($compressor_file); # date ("F d Y H:i:s.", filemtime($fn));
                $file_details['size'][$i] = filesize($compressor_file);
            } else {
                #echo("<br>{$file} does not exist");
            }
        }

        /**
         * Identify the cache name for this combination of files.
         */
        #\common\stopper::debug($file_details, false);
        $file_details['details'] =
            $compression_type .
            implode("", $file_details['name']) .
            implode("", $file_details['time']) .
            implode("", $file_details['size']);
        $file_details['cache_name'] = $this->directory_cached . '/' . md5($file_details['details']) . '.cache';
        #\common\stopper::debug($file_details, false);

        if (!file_exists($file_details['cache_name'])) {
            # Compact the code before writing to the file
            # Do as valid, and and as needed.
            # Additional only. If at debugging, do not use this.
            # Major portion to shrink the file size.
            if ($compression_type == 'javascript') {
                #\common\stopper::message('js compression...');
                $this->compact_code_javascript();
                $this->content_type = 'text/javascript';
            } else {
                #\common\stopper::message('css compression...');
                $this->compact_code_css();
                $this->content_type = 'text/css';
            }
            # More, ... possible here


            # Append or prepend the license file now, to the compressed output
            # Fashionably decorates the plain license text with starting * of the comments.
            # This block is optional.
            $license_file = "license.{$compression_type}.txt";
            $license_contents = "";
            if (file_exists($license_file)) {
                #$license_contents = file_get_contents($license_file);
                # splid with: \r\n or, \n
                $license_contents = implode("\r\n", array_map(array(&$this, 'comment_start'), explode("\r\n", file_get_contents($license_file))));
                $this->compressor_contents = "/**\n" . $license_contents . "\n**/\n" . $this->compressor_contents;
            }

            # Generate and print the file contents now!
            # Save the file, so that it will be reused later on.
            $fp = fopen($file_details['cache_name'], 'w+');
            fwrite($fp, $this->compressor_contents);
            fclose($fp);
        } else {
            # Read out the cached file now. This file is valid, for the combination of the files.
            #readfile($file_details['cache_name']); # Static contents here!
            $this->compressor_contents = file_get_contents($file_details['cache_name']);
        }
    }

    /**
     * Compress the javascript code in some legal way.
     */
    public function compact_code_javascript()
    {
        # Cleaning...

        # Remove the comments in /* ... */ boundaries
        # JS comments can not be nested anymore
        $this->compressor_contents = preg_replace('/\/\*.*?\*\//s', "", $this->compressor_contents);

        # Remove the comments in lines startring from //
        $this->compressor_contents = preg_replace('/^\/\/.*?$/m', "", $this->compressor_contents);

        # Remove the comments in lines having // and comments there after.
        # Risky: Be careful for the enclosed " // " things withing the variables.
        $this->compressor_contents = preg_replace('/\/\/.*?$/m', "", $this->compressor_contents); # Removes ANY: RISKY

        # Compact, by removing the beginning whitespaces
        $this->compressor_contents = preg_replace('/^[\s]+/m', "", $this->compressor_contents); # Removes ANY: RISKY
    }

    /**
     * Compress the css code in some legal way.
     */
    public function compact_code_css()
    {
        # Cleaning...

        # Compress the texts
        #$this->compressor_contents = preg_replace('![\s]+!m', ' ', $this->compressor_contents);

        # Remove the comments in /* ... */ boundaries
        # CSS comments can not be nested anymore
        $this->compressor_contents = preg_replace('/\/\*.*?\*\//is', "", $this->compressor_contents);

        # Tighten the boundaries.
        # Compact the whitespaces around the braces
        #$this->compressor_contents = preg_replace('/\s.(\{|\})\s./is', '\1', $this->compressor_contents);
        $this->compressor_contents = preg_replace('/[\s]+(\{|\})[\s]+/is', '$1', $this->compressor_contents);

        # NOT frequently useful.
        # CSS safety, when a javascript was used with this, throw the line away.
        $this->compressor_contents = preg_replace('/\/\/.*?$/m', "", $this->compressor_contents); # Removes ANY: RISKY

        # Remove thet newline and tabs together.
        $this->compressor_contents = preg_replace('/[\r|\n]+[\t| ]+/is', ' ', $this->compressor_contents);

        # Compact other white spaces
        $this->compressor_contents = preg_replace('/[\s]+/is', ' ', $this->compressor_contents);

        # Compact the less useful, blank tags: Just defined only.
        $this->compressor_contents = preg_replace('/\{\s+\}/im', '{}', $this->compressor_contents);

        # Space savers
        #\common\stopper::message('sss: '.$this->compressor_contents);
        #$this->compressor_contents = preg_replace('/([\:|\,|\;])\s+/im', '\\1', $this->compressor_contents);
        $this->compressor_contents = preg_replace('/\s*([\:|\,|\;|\{|\}])\s*/im', '\\1', $this->compressor_contents); # too compacting
    }

    public function send_headers($compressor_name = 'combined.js.css.txt')
    {
        $compressor_size = strlen($this->compressor_contents);

        header("Cache-Control: must-revalidate");
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + 259200) . " GMT"); # Force caching, 3 days in future ( time in seconds ) 60*60*24*3
        header("content-type: {$content_type}"); # text/plain text/javascript text/css
        header("Content-Disposition: inline; filename=\"{$compressor_name}\"");
        header("Content-Length: {$compressor_size}"); # Necessary sometimes.

        echo($this->compressor_contents);
    }

    public function comment_start($snippet_line = "")
    {
        return "* {$snippet_line}";
    }
}
