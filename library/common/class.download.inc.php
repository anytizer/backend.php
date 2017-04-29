<?php
namespace common;

/**
 * Allows a file to download
 */
class download
{
    private $error;
    private $inline; # Show it in the inline? or force to download?

    /**
     * Begin, Error as Yes!
     */
    public function __construct($inline = false)
    {
        $this->error = false;
        if (headers_sent()) {
            $this->error = true;
        }

        $this->inline = ($inline === true);
    }

    /**
     * Read and send a file to the client browser.
     */
    public function send_file($filename_path = "", $save_name = "")
    {
        #\common\stopper::message("Download for: {$filename} n save as: {$save_name}");

        if ($this->error) {
            return false;
        }

        $filesize = 0;

        if (file_exists($filename_path) && is_file($filename)) {
            $filesize = filesize($filename_path);
            $this->headers($this->save_name($filename_path, $save_name), $filesize);
            readfile($filename_path);

            return true;
        } else {
            $this->send_error_contents();
        }

        return false;
    }

    /**
     * Send some headers useful to the downloader client.
     */
    private function headers($filename = "", $length = 0)
    {
        if (!$filename || !$length || $this->error) {
            return false;
        }

        header("Pragma: anytextexeptno-cache", true); # MSIE
        header("Pragma: public");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: pre-check=0, post-check=0, max-age=0");
        header("Cache-Control: private", false);
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate('D, d M Y H:i:s') . " GMT");
        header("Content-Transfer-Encoding: binary");
        if ($this->inline) {
            # Show within the browser
            header("Content-Disposition: inline; filename=\"{$filename}\"");
        } else {
            # Force download
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/force-download");
        }
        header("Content-length: {$length}");

        return true;
    }

    /**
     * Convert a base file name into a name that can be saved on a client's computer
     */
    public function save_name($save_name = "")
    {
        $save_name = preg_replace('/[^a-z0-9\_\-\.]+/', "", $save_name);

        return $save_name;
    }

    /**
     * When file was not sent, send an alternative error texts.
     * It is a readable file to describe what happened.
     */
    function send_error_contents($filename = "")
    {
        $timestamp = date('Y-m-d H:i:s');
        $tz = date('YmdHis');
        $filename = !empty($filename) ? $filename : '__EMPTY__';
        $error = "Hi!,
You requested to download the file: [ {$filename} ].
I am sorry, I can not find this file on the server.

Or,
Probably you were trying to download an unauthorized file.
Please secure your account.

Administrator
{$timestamp}
";
        $this->headers("nothing.{$tz}.txt", strlen($error));
        echo $error;
    }

    /**
     * Sends an uploaded file.
     *
     * @param array $uploaded_file as read from query_uploads
     * @return bool
     */
    public function send_uploaded_file($uploaded_file = array())
    {
        #print_r($uploaded_file);
        # validate $uploaded_file array...
        /*
        Array
        (
            [upload_id] => 7
            [upload_size] => 1835
            [uploaded_on] => 1272960036
            [downloads_counter] => 0
            [file_code] => 20100504010036769
            [file_name] => valid-sv.png
            [file_mime] => images/png
            [file_location] => /portfolio-images
            [comments_file] => Tue, 04 May 10 01:00:36 -0700
            [comments_additional] => portfolio product images
            [is_active] => Y
        )
        */
        $is_sent = false;
        $filename = $uploaded_file['file_location'] . '/' . $uploaded_file['file_code'];
        if (file_exists($filename) && is_file($filename)) {
            $filesize = filesize($filename);
            #header("Content-Type: images/png");
            $this->headers($this->save_name($uploaded_file['file_name']), $filesize);
            readfile($filename);
            $is_sent = true;
        } else {
            $this->send_error_contents();
        }

        return $is_sent;
    }

    public function details($filename = "")
    {
        $is_valid = is_file($filename);

        $meta = array();
        $meta['name'] = ($is_valid) ? basename($filename) : "";
        $meta['filesize'] = ($is_valid) ? filesize($filename) : 0;
        $meta['mtime'] = ($is_valid) ? filemtime($filename) : 0;
        $meta['location'] = ($is_valid) ? $filename : "";
        #$meta['extension'] = ($is_valid)?($filename):0;

        $meta = array_map('addslashes', $meta);

        return $meta;
    }
}

