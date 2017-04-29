<?php
namespace third;

/**
 * This class is not part of Resize and upload image class.
 * this class is property of some one else.
 * I get this from phpclasses.org but forget the name of author.
 * sorry for that.
 *
 * @package Uploader
 */
class imageresizer
{
    var $FileName;
    var $FileSize;
    var $FileType;
    var $AllowedExtentions = array("image/png", "image/gif", "image/jpeg", "image/pjpeg", "image/jpg", "mp4", "flv");
    var $newWidth = 100; // new width
    var $newHeight = 100; //new height
    var $TmpName;
    var $PicDir; //store uploaded images
    var $MaxFileSize = 102400000; //kbytes
    var $ImageQuality = 100; // image compression (max value 100)


    function __construct($FileName)
    {
        $this->FileName = $FileName;
    }

    function GetInfo()
    {
        $out = '  <br><br>Upload success!<br>
            			Name: ' . $this->FileName . '<br>
                    file size: ' . $this->FileSize . ' byte<br>
                    file type: ' . $this->FileType . '<br>
					<img src=' . dirname($_SERVER['PHP_SELF']) . '/' . $this->PicDir . $this->FileName . '><br><br>';

        return $out;
    }

    function Resize()
    {
        // header('Content-Type: image/gif');
        if (empty  ($this->TmpName)) {
            return $this->GetError(2);
        } else if ($this->FileSize > $this->MaxFileSize) {
            return $this->GetError(1);
        } else if ($this->GetFileExtention($this->FileName) == false) {
            return $this->GetError(0);
        } else if ($this->ExistFile()) {
            return $this->GetError(3);
        } else {

            $ext = explode(".", $this->FileName);
            $ext = end($ext);
            $ext = strtolower($ext);

            // Get new sizes
            list($width_orig, $height_orig) = getimagesize($this->TmpName);

            $ratio_orig = $width_orig / $height_orig;

            if ($this->newWidth / $this->newHeight > $ratio_orig) {
                $this->newWidth = $this->newHeight * $ratio_orig;
            } else {
                $this->newHeight = $this->newWidth / $ratio_orig;
            }

            $normal = imagecreatetruecolor($this->newWidth, $this->newHeight);

            if ($ext == "jpg") {
                $source = imagecreatefromjpeg($this->TmpName);
            } else if ($ext == "gif") {
                $source = imagecreatefromgif($this->TmpName);
            } else if ($ext == "png") {
                $this->ImageQuality = 9;
                $source = imagecreatefrompng($this->TmpName);
            }

            imagecopyresampled($normal, $source, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width_orig, $height_orig);


            if ($ext == "jpg") {
                //ob_start();
                imagejpeg($normal, "$this->PicDir/$this->FileName", "$this->ImageQuality");
                //$binaryThumbnail = ob_get_contents();
                //ob_end_clean();
            } else if ($ext == "gif") {
                imagegif($normal, "$this->PicDir/$this->FileName", "$this->ImageQuality");
            } else if ($ext == "png") {
                imagepng($normal, "$this->PicDir/$this->FileName", "$this->ImageQuality");
            }

            imagedestroy($source);
            //echo $this -> GetInfo();

        }
    }

    function GetError($error)
    {

        switch ($error) {
            case 0 :
                return "Error: Invalid file type <b>$this->FileType</b>! Allow type: .jpg, .jpeg, .png, .png  <b>$this->FileName</b><br>";
                break;

            case 1 :
                return "Error: File <b>$this->FileSize</b> is too large! You must upload 1000 MB file<br>";
                break;

            case 2 :
                return "Error: Please, select a file for uploading!<br>";
                break;

            case 3 :
                return "Error: File <b>$this->FileName</b> already exist!<br>";
                break;
        }
    }

    function GetFileExtention($FileName)
    {
        if (in_array($this->FileType, $this->AllowedExtentions)) {
            return true;
        } else {
            return false;
        }
    }

    function ExistFile()
    {
        $fileexist = $_SERVER['DOCUMENT_ROOT'] .
            dirname($_SERVER['PHP_SELF']) .
            '/' . $this->PicDir .
            $this->FileName;
        if (file_exists($fileexist)) {
            return true;
        }
    }

    function Save()
    {
        if (empty  ($this->TmpName)) {
            return $this->GetError(2);
        } else if ($this->FileSize > $this->MaxFileSize) {
            return $this->GetError(1);
        } else if ($this->GetFileExtention($this->FileName) == false) {
            return $this->GetError(0);
        } else if ($this->ExistFile()) {
            return $this->GetError(3);
        } else {

            copy($this->TmpName, $this->PicDir . $this->FileName);
            //echo $this -> GetInfo();

        }
    }
}
