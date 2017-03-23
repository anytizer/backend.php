<?php
namespace common;

/**
 * Proportionate resizing dimensions cacluator
 *
 * @package Common
 */
class dimensions
{
    # Original image sizes
    private $original_width = 0;
    private $original_height = 0;

    # Expected maximum area
    private $canvas_width = 0;
    private $canvas_height = 0;

    # Best selected dimension to keep the proportion
    private $selected_width = 0;
    private $selected_height = 0;

    /**
     * Begin with original image size
     *
     * @param int $width
     * @param int $height
     */
    public function __construct($width = 0, $height = 0)
    {
        # Input parameter validation
        $width = abs((int)$width);
        $height = abs((int)$height);
        $this->original_width = $width;
        $this->original_height = $height;
    }

    /**
     * Set the maximum canvas size
     * This sets the selected_width and select_width variables
     *
     * @param int $width
     * @param int $height
     */
    public function canvas($width = 0, $height = 0)
    {
        # Input parameter validation
        $width = abs((int)$width);
        $height = abs((int)$height);
        $this->canvas_width = $width;
        $this->canvas_height = $height;

        $set1_width = $width;
        $set1_height = ceil($width * $this->original_height / $this->original_width);

        $set2_width = ceil($this->original_width * $height / $this->original_height);
        $set2_height = $height;

        if ($set1_width <= $width && $set1_height <= $height) {
            $this->selected_width = $set1_width;
            $this->selected_height = $set1_height;
        } else {
            $this->selected_width = $set2_width;
            $this->selected_height = $set2_height;
        }
        /*
        echo "\r\nOriginal: {$this->original_width} x {$this->original_height}";
        echo "\r\nFit to: {$this->canvas_width} x {$this->canvas_height}";
        echo "\r\nSet 1: {$set1_width} x {$set1_height}";
        echo "\r\nSet 2: {$set2_width} x {$set2_height}";
        echo "\r\nSelected: {$this->selected_width} x {$this->selected_height}";
        echo "\r\n", $this->get_width(), 'x', $this->get_height();
        echo "\r\n";*/
    }

    /**
     * Get the calculated width
     *
     * @return int
     */
    public function get_width()
    {
        return $this->selected_width;
    }

    /**
     * * Get the calculated height
     *
     * @return int
     */
    public function get_height()
    {
        return $this->selected_height;
    }
}

