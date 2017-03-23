<?php
namespace common;

/**
 * Matches a directory for certain file types.
 *
 * @package Interfaces
 */
class matchagainst
{
    protected $files = array();
    private $path = null;
    private $error = true;
    private $skip_list = array('.', '..');
    private $regexp_filter = "";

    public function __construct($path = '/tmp', $regexp_filter = "")
    {
        if (is_dir($path)) {
            $this->path = $path;
            $this->error = false;
        } else {
            \common\stopper::message('Requested directory does not exist: ' . $path);
        }

        $this->regexp_filter = $regexp_filter;
    }

    /**
     * Build a list of matched files
     */
    public function match()
    {
        if (!$this->error && $dir_handle = opendir($this->path)) {
            while (false !== ($filename = readdir($dir_handle))) {
                if (in_array($filename, $this->skip_list)) {
                    continue;
                }

                $full_file_path = "{$this->path}/{$filename}";

                if (is_file($full_file_path)) {

                    if ($this->regexp_filter) {
                        # Match and filter, if regular expression filter is used.
                        if (preg_match($this->regexp_filter, $filename)) {
                            $this->files[] = $filename;
                        }
                    } else {
                        # Do not filter anything. Consider all files.
                        $this->files[] = $filename;
                    }
                }
            }
        }
    }

    /**
     * What is the current search location?
     */
    public function path()
    {
        return $this->path;
    }
}