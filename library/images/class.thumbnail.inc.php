<?php
namespace images;

/**
 * Thumbnail generator. Currently supports jpeg only
 * Also, crop an image: PNG, JPG, with true trype color support.
 *
 * @package Common
 */
class thumbnail
{
    public $original = array();
    public $thumb_binary; # Binary string of thumbnail output
    public $crop_sizes; # Sizes of a cropped image

    public function __construct()
    {
        $this->thumb_binary = "";
    }

    public function load($original_name = "")
    {
        $this->original = array();
        $this->original['name'] = $original_name; # 'test.jpg';
        list($this->original['width'], $this->original['height']) = getimagesize($this->original['name']);
    }

    public function generate($newwidth = 0, $newheight = 0)
    {
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($this->original['name']);

        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $this->original['width'], $this->original['height']);

        // Output
        ob_start();
        imagejpeg($thumb);
        $this->thumb_binary = ob_get_contents();
        ob_end_clean();
    }

    public function save($location_name = "")
    {
        # Returns the number of bytes saved in this image
        return file_put_contents($location_name, $this->thumb_binary, FILE_BINARY);
    }


    /**
     * Crop functions
     */
    public function crop($source = 'source.jpg', $dest = 'dest.jpg', $crop_from = array(0, 0), $crop_for = 'image')
    {
        #\common\stopper::debug($crop_from, false);
        #\common\stopper::debug($this, false);
        #\common\stopper::message($crop_for);

        # $x = 30; $y = 70;
        $x = (int)$crop_from[0];
        $y = (int)$crop_from[1];

        #$w = 100; $h = 100;
        $crop_for = !array_key_exists($crop_for, $this->crop_sizes) ? 'image' : $crop_for;
        $w = (int)$this->crop_sizes[$crop_for][0];
        $h = (int)$this->crop_sizes[$crop_for][1];

        $simg = imagecreatefromjpeg($source);
        #$dimg = imagecreatetruecolor(100, 100); # Canvas # imagecreate
        $dimg = imagecreatetruecolor($w, $h); # Canvas # imagecreate # From the request, use the dimensions.

        #\common\stopper::message("Cropping as: ($x, $y), ($w, $h)");
        imagecopy($dimg, $simg, 0, 0, $x, $y, $w, $h);

        imagejpeg($dimg, $dest, 100);
        #imagejpeg($dimg, $dest);
    }


    /**
     * Height and width of an image source
     */
    public function dimensions($source_image = "")
    {
        // create a 300*200 image
        #$img = imagecreatetruecolor(300, 200);
        #echo imagesx($img); // 300

        #$sizes = getimagesize($source_image);
        #\common\stopper::message($sizes);
        /*
        Array
        (
            [0] => 300
            [1] => 335
            [2] => 2
            [3] => width="300" height="335"
            [bits] => 8
            [channels] => 3
            [mime] => image/jpeg
        )
        */
        $dimensions = array();
        $dimensions['height'] = 0;
        $dimensions['width'] = 0;

        if (is_file($source_image) && $sizes = getimagesize($source_image)) {
            $dimensions['width'] = $sizes[0];
            $dimensions['height'] = $sizes[1];
        }

        return $dimensions;
    }
}