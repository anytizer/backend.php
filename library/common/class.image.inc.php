<?php
namespace common;

/**
 * Crop an image
 *
 * @package Common
 */
class image
{
    public $crop_sizes;

    public function __construct()
    {
        $this->crop_sizes['image'] = array(100, 100);
        $this->crop_sizes['banner'] = array(500, 50);
    }

    public function crop($source = 'source.jpg', $dest = 'destination.jpg', $crop_from = array(0, 0), $crop_for = 'image')
    {
        # $x = 30; $y = 70;
        $x = $crop_from[0];
        $y = $crop_from[1];

        #$w = 100; $h = 100;
        $crop_for = !array_key_exists($crop_for, $this->crop_sizes) ? 'image' : $crop_for;
        $w = $this->crop_sizes[$crop_for][0];
        $h = $this->crop_sizes[$crop_for][1];

        if (!file_exists($source)) {
            return false;
        }

        $simg = imagecreatefromjpeg($source);
        #$dimg = imagecreatetruecolor(100, 100); # Canvas # imagecreate
        $dimg = imagecreatetruecolor($w, $h); # Canvas # imagecreate

        #\common\stopper::message("Cropping as: ($x, $y), ($w, $h)");
        imagecopy($dimg, $simg, 0, 0, $x, $y, $w, $h);

        imagejpeg($dimg, $dest); //, 100);
        return true;
    }

    public function color_copy_crop($source = 'source.jpg', $dest = 'dest.jpg', $crop_from = array(0, 0), $crop_for = 'image')
    {
        $simg = imagecreatefromjpeg($source);
        $dimg = imagecreatetruecolor(100, 100); # Canvas # imagecreate

        # $x = 30; $y = 70;
        $x = $crop_from[0];
        $y = $crop_from[1];

        #$w = 100; $h = 100;
        $crop_for = !array_key_exists($this->$crop_for, $this->crop_sizes) ? 'image' : $crop_for;
        $w = $this->crop_sizes[$crop_for][0];
        $h = $this->crop_sizes[$crop_for][1];

        /*
        # bool imagesetpixel ( resource image, int x, int y, int color )

        $im = ImageCreateFromPng("rockym.png");
        $rgb = ImageColorAt($im, 100, 100);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        */

        #$wt = $x+$w; $ht = $y+$h;
        $wt = $w;
        $ht = $h;

        #\common\stopper::message("Cropping as: ($x, $y), ($w, $h)");

        #for($wi=$w; $wi<$wt; ++$wi)
        for ($wi = 0; $wi < $wt; ++$wi) {
            for ($hi = 0; $hi < $ht; ++$hi) {
                $px = $x + $wi;
                $py = $w + $hi;
                $rgb = imagecolorat($simg, $px, $py);

                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $color = imagecolorallocate($dimg, $r, $g, $b);

                #echo("<br>({$px}, $py) => ($wi, $hi) : {$rgb}($r, $g, $b)/$color");

                #imagesetpixel($dimg, $px, $py, $color);
                imagesetpixel($dimg, $wi, $hi, $color);
                #imageline($dimg, $wi, $hi, $wi, $hi, $rgb);
            }
        }

        #imagecopy($dimg, $simg, 0, 0, $x, $y, $w, $h);
        imagejpeg($dimg, $dest, 100);
        #imagepng($dimg, $dest, 100);
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
        #\common\stopper::debug($sizes, false);
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

        if ($sizes = getimagesize($source_image)) {
            $dimensions['width'] = $sizes[0];
            $dimensions['height'] = $sizes[1];
        }

        return $dimensions;
    }
}
