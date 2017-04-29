<?php
namespace others;

/**
 * Data Type for an email's subject/body:html/alternative:text
 *
 * @package Interfaces
 */
class datatype_email
    extends \abstracts\datatype
{
    /**
     * Set the variables properly
     */
    public function __construct($subject = "", $html = "", $text = "")
    {
        parent::__construct(array(
            'subject',
            'html',
            'text'
        ));

        $this->subject = $subject;
        $this->html = $html;
        $this->text = $text;
    }


    /**
     * Force a copy of $this, otherwise it will point to same object.
     * @see http://php.net/manual/en/language.oop5.cloning.php
     */
    public function __clone()
    {
        $cloned = clone $this;

        return $cloned;
    }


    /**
     * Checks and verifies for integrity of data.
     * If it returns false, the email will not be delivered.
     */
    public function is_valid()
    {
        # Validate Subject
        # Validate HTML
        # validate Text

        # For now, let us assume, no errors occurred.
        return true;
    }
}
