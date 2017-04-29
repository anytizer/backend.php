<?php
namespace common;

/**
 * Puts icons of a directory into a icon, and writes a css.
 * Strategy is to help reduce an HTTP request for background images of the icons.
 * @see images/selected-icons/*.png
 * @see images/iconizer.php
 * @see images/test/*.*
 */
class iconizer
{
    /**
     * Dimensions of a cell
     */
    private $icon_width;
    private $icon_height;

    /**
     * Matrix of icons
     */
    private $columns;
    private $rows;

    /**
     * Image Resource
     */
    private $image;

    public function __construct($icon_width = 0, $icon_height = 0, $columns = 0, $rows = 0)
    {
        $this->icon_width = (int)$icon_width;
        $this->icon_height = (int)$icon_height;

        $this->columns = (int)$columns;
        $this->rows = (int)$rows;

        $this->image = imagecreatetruecolor($this->icon_width * $this->columns, $this->icon_height * $this->rows);

        $background_color = imagecolorallocate($this->image, 0xFF, 0xFF, 0xFF);
        imagefill($this->image, 0, 0, $background_color);
    }

    /**
     * Reads a directory of images and produces: css and a big image file
     */
    public function iconize($directory = "", $css_filename = "")
    {
        $i = 0;
        $samples = array();
        $samples[] = "<ol>";
        $css = array();

        /**
         * @todo Keep the files in temporary area
         * @see iconizer.php
         */
        $random_name = \common\tools::random_text(10);
        # $css_filename = $random_name.'.css';
        $html_filename = $random_name . '.html';
        $image_filename = $random_name . '.png';

        # Maximum number of the reservoir
        $total_images_allowed = $this->columns * $this->rows;

        if ($handle = opendir($directory)) {
            #echo "Directory handle: $handle\nFiles:\n";
            while (false !== ($file = readdir($handle))) {
                # .png only
                $data = array();
                if (!preg_match_all('/^(.*?)\.png$/is', $file, $data, PREG_SET_ORDER)) {
                    continue;
                }
                #\common\stopper::debug($data, false);

                $image = $directory . '/' . $data[0][0];
                $name = $data[0][1];
                #if(!is_file($image)) continue; # Validates an image file

                $column = $this->column($i);
                $row = $this->row($i);

                $icon_x = $row * $this->icon_height + (($row > 0) ? 1 : 0);
                $icon_y = $column * $this->icon_width + (($column > 0) ? 1 : 0);

                # Helpful debugger
                #echo("{$i}: [{$column}][{$row}] = [{$icon_x}]px, [{$icon_y}]px = {$file}\r\n");

                #$css[] = ".{$name}\{background-position:-48px -16px;\}";
                $css[] = ".{$name}{background-position:-{$icon_x}px -{$icon_y}px;}";
                $samples[] = "<li><img src=\"blank.png\" class=\"icon {$name}\" /> {$name}</li>";

                $icon_image = imagecreatefrompng($image);

                imagecopy(
                    $this->image, $icon_image,
                    $icon_x, $icon_y,
                    0, 0,
                    $this->icon_width, $this->icon_height
                );

                # Avoid memory error when number of images is greater than the capacity of an image
                if (++$i >= $total_images_allowed) {
                    break;
                }
            } # while

            $samples[] = "</ol>";

            # Dump the image file and other related files (.png, .css, .html)

            $test_dir = realpath($directory);
            if (!is_writable($test_dir)) {
                throw new \Exception("Cannot write images to  directry[{$test_dir}]");
            }

            imagepng($this->image, $test_dir . '/' . $image_filename, 9, PNG_NO_FILTER);

            $css[] = "
.icon
{
	background-image:url({$image_filename});
	background-repeat:no-repeat;
	height:{$this->icon_height}px;
	width:{$this->icon_width}px;
}";
            file_put_contents($test_dir . '/' . $css_filename, implode("\r\n", $css));
            file_put_contents(
                $test_dir . '/' . $html_filename,
                "<link href=\"{$css_filename}\" rel=\"stylesheet\" type=\"text/css\" />" . implode("\r\n", $samples)
            );
        }

        return $html_filename;
    }

    # Finds out the x/y of a cell

    private function column($runner = 0)
    {
        # column = x = width
        $column = floor($runner / $this->columns);

        #echo("$column = floor($runner/$this->columns);");
        return $column;
    }

    private function row($runner = 0)
    {
        # row = y = height
        $row = $runner % $this->columns;

        #echo("$row = $runner%$this->columns;");
        return $row;
    }
}
