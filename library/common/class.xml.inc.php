<?php
namespace common;

/**
 * XML generating class
 *
 * @package Common
 * @dependency element class
 */
class xml
    extends element
{
    /**
     * @param $children array List of children elements or xml objects
     */
    public $children;

    /**
     * Construtor
     * <br>Calls constructor of element class too.
     */
    public function __construct()
    {
        parent::__construct();
        $this->children = array();
    } # xml()

    /**
     * Add an element to the node.
     *
     * @param object $element Object of {@link element.html element} type
     *
     * @return integer Index of the currently added child in the pool
     */
    public function child_add($element)
    {
        if (!is_object($element)) {
            return false;
        }

        $this->children[] = $element;

        $current_index = count($this->children) - 1;

        return $current_index;
    } # child_add()

    /**
     * Add an element to the node.
     *
     * @param object $element Object of {@link element} type
     *
     * @return integer Index of the currently added element in the pool
     */
    public function element_add($element)
    {
        if (!is_object($element)) {
            return false;
        }

        $this->children[] = $element;

        $current_index = count($this->elements) - 1;

        return $current_index;
    } # element_add()

    /**
     * Recursively build final xml output
     * <br>Appends XML headline.
     * <br>Compiles elements and xml data
     *
     * @param integer $depth Depth of the XML node
     *
     * @uses Must use xml heading to the output stream for proper handling
     * @return string XML output
     */
    public function assemble_xml($depth = 0)
    {
        $xml = "";
        if ($depth == 0) {
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"\n";
        }
        $children_count = count($this->children) + 0;

        if ($children_count > 0) {
            $xml .= $this->get_header();

            for ($i = 0; $i < $children_count; ++$i) {
                /**
                 * Try to format the XML output
                 */
                $xml .= $this->separator($depth, true) . $this->children[$i]->assemble_xml($depth + 1) . $this->separator($depth - 1, true);

                /**
                 * Do not format the XML output
                 */
                #$xml.=$this->children[$i]->assemble_xml($depth+1);
            }

            $xml .= $this->get_footer();
        } else {
            $xml .= $this->assemble();
        }

        #$xml = preg_replace('!\s+!', ' ', $xml); # Poor compression
        #$xml = preg_replace("![\n|\r|\t]+!", "\n", $xml); # Compress in each line
        $xml = preg_replace("![\n|\r|\t]+!", "", $xml); # Compressed fully

        return $xml;
    } # assemble_xml()

    /**
     * For XML output formatting purpose.
     * <br>Output spacing is depth dependent.
     *
     * @param integer $depth Depth of XML node
     * @param boolean $eol End of Line notification, for output separator control
     *
     * @return string Spaces required for the current xml node.
     */
    public function separator($depth = 0, $eol = false)
    {
        $separator = "\n";
        if ($eol == false) {
            $separator = "";
        }

        $basic_separator = "  ";
        for ($x = 0; $x < $depth; ++$x) {
            $separator .= $basic_separator;
        }

        return $separator;
    } # separator()
}
