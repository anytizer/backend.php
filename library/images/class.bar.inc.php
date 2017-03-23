<?php
namespace images;

/**
 * Image Bar Producer
 * @example `<img src="bar.php?width=500&height=20&score=54&fullmarks=300" width="500" height="20" />`
 */
class bar
{
    private $score; # Score
    private $fullmarks; # Full Makrs
    private $percentage; # Percentage gained

    private $score_width; # Score's filling width
    private $width; # Full width of the image
    private $height; # Height

    private $image; # Image Resource

    /**
     * Immediately set the dimensions.
     */
    public function __construct($width = 500, $height = 20)
    {
        $this->width = abs($width); # 500; # For 100% score
        $this->height = abs($height); # 20;

        # Prepare the image
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    /**
     * Draw the bar
     */
    public function draw($score = 0, $fullmarks = 100)
    {
        $this->fullmarks = abs($fullmarks);
        $this->score = abs($score);
        $this->score = ($this->score > $this->fullmarks) ? $this->fullmarks : $this->score;

        $this->percentage = round(($this->score / $this->fullmarks) * 100, 2);
        $this->score_width = ceil(($this->width / 100) * $this->percentage);
        #echo("\n{$this->score}/{$this->fullmarks} = {$this->percentage}% = {$this->score_width}px");

        # Draw the image
        #$background_color = imagecolorallocate($this->image, 0xCC, 0xCC, 0xCC);
        #$mark_color = imagecolorallocate($this->image, 0x00, 0x00, 0xCC);
        $background_color = imagecolorallocate($this->image, 0xDD, 0xDD, 0xDD);
        $mark_color = imagecolorallocate($this->image, 0xD1, 0x97, 0x77); # Browish
        imagefill($this->image, 0, 0, $background_color); # Make the background
        imagefilledrectangle($this->image, 0, 0, $this->score_width, $this->height, $mark_color); # Make the marking

        $this->mark_percentage(number_format($this->percentage, 2, '.', ',') . '%');

        header("Content-type: image/png");
        imagepng($this->image);
        imagedestroy($this->image);
    }

    /**
     * Put the text marker
     */
    private function mark_percentage($image_text = "")
    {
        if ($image_text == "") {
            # Why to bother, when there is nothing?
            return false;
        }

        $text_size = 5; # Fixed

        $imgw = $this->width;
        $imgh = $this->height;

        #$textcolor = imagecolorallocate($this->image, 0xFF, 0x00, 0x33);
        $textcolor = imagecolorallocate($this->image, 0x00, 0x00, 0x00);

        $t_h = $t_w = $t_x = $t_y = 0;
        $base_w = 9;
        $base_h = 16;
        $m = 0.88;
        $mm = 0.98;
        switch ($text_size) {
            case 1:
                $t_w = $base_w * pow(($m * $mm), 4);
                $t_h = $base_h * pow(($m * $mm), 4);
                break;
            case 2:
                $t_w = $base_w * pow($m, 3);
                $t_h = $base_h * pow($m, 3);
                break;
            case 3:
                $t_w = $base_w * pow($m, 2);
                $t_h = $base_h * pow($m, 2);
                break;
            case 4:
                $t_w = $base_w * $m;
                $t_h = $base_h * $m;
                break;
            case 5:
                $t_w = $base_w;
                $t_h = $base_h;
                break;
            default:
                if ($text_size >= 5) // set to 5
                {
                    $t_w = $base_w;
                    $t_h = $base_h;
                }
                if ($text_size < 5) // set to 1
                {
                    $t_w = $base_w * pow(($m * .98), 4);
                    $t_h = $base_h * pow(($m * .98), 4);
                }
                break;
        }

        $text_array = array();

        $max = floor($imgw / $t_w);

        for ($i = 0; strlen($image_text) > 0; $i += $max) {
            array_push($text_array, substr($image_text, 0, $max));
            if (strlen($image_text) >= $max) {
                $image_text = substr($image_text, $max);
            } else {
                $image_text = "";
            }
        }

        $t_y = ($imgh / 2) - ($t_h * count($text_array) / 2);
        foreach ($text_array as $text) {
            $t_x = ($imgw / 2) - ($t_w * strlen($text) / 2);
            imagestring($this->image, $text_size, $t_x, $t_y,
                $text, $textcolor);
            $t_y += $t_h;
        }
    }
}
