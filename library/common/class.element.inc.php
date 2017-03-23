<?php
namespace common;

/**
 * XML element generating class
 *
 * @package Common
 * @dependency xml class
 */
class element
{
    /**
     * @var $name string Element name (tag).
     */
    public $name;
    /**
     * @var $attributes array List of attributes to add to the element.
     */
    public $attributes;
    /**
     * @var $data string Data enclosed by the opening and closing tags.
     */
    public $data;

    /**
     * Constuctor
     * <br>Reserves spaces for the member items.
     */
    public function __construct()
    {
        $this->name = "";
        $this->attributes = array();
        $this->data = "";
    } # element()()

    /**
     * Set the name of the element
     *
     * @var string $name Name of the element
     */
    public function name($name = "")
    {
        $this->name = $name;
    } # name()

    /**
     * Add a unique attribute and its value.
     * If an attribute repeats, it overlaps the older value.
     *
     * @param string $name Name of the attribute.
     * @param string $value Corresponding value of the attribute.
     *
     * @return boolean Was the attribute added successfully?
     */
    public function attribute_add($name = "", $value = "")
    {
        if ($name != "" && $value != "") {
            $this->attributes[$name] = $value;

            return true;
        }

        return false;
    } # attribute_add()

    /**
     * Reset all of the attributes, if there were any.
     *
     * @uses When the object can reused with same name, clean the attributes first.
     * @uses Best for using within loops
     */
    public function attributes_clean()
    {
        $this->attributes = array();
    } # attributes_clean()

    /**
     * Set data for the element.
     *
     * @param string $data Data contents
     */
    function data($data = "")
    {
        $this->data = "{$data}"; # Make it a string
    } # data()

    /**
     * Compile an element
     * Compiles header: Opening tag
     * Compiles data (or body)
     * Compiles footer: Closing tag
     * Output can be used as a part of another XML data
     *
     * @return string Compiled XML of an element.
     */
    public function assemble()
    {
        $output = "";
        $output = $this->get_header();
        $output .= $this->get_data();
        $output .= $this->get_footer();

        return $output;
    } # assemble()

    /**
     * Compile the beginning tag of the element.
     *
     * @return string <strong>&lt;ELEMENT attribute='value' ... &gt;</strong> part
     */
    public function get_header()
    {
        $output = "<{$this->name}" . $this->attributes_assemble($this->attributes) . ">";

        return $output;
    } # attributes_assemble()

    /**
     * Compiles the list of attributes assigned.
     *
     * @access private
     *
     * @param array $data
     *
     * @return string Association of attributes and values.
     */
    public function attributes_assemble($data = array())
    {
        if (!is_array($data) && is_string($data)) {
            return "{$data}";
        }

        $output = "";
        foreach ($data as $name => $value) {
            $output .= " {$name}=\"{$value}\"";
        }

        return $output;
    } # get_header()

    /**
     * Compile the data (or main body)
     *
     * @return string Data part, enclosed withing the <strong>&lt;ELEMENT&gt;</strong> and <strong>&lt;/ELEMENT&gt;</strong> tags.
     */
    public function get_data()
    {
        $output = $this->attributes_assemble($this->data);

        return $output;
    } # get_footer()

    /**
     * Compile the ending tag of the element.
     *
     * @return string <strong>&lt;/ELEMENT&gt;</strong> part
     */
    public function get_footer()
    {
        $output = "</{$this->name}>";

        return $output;
    } # get_data()
}
