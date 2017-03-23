<?php
namespace backend;

/**
 * Framework specific \Exceptions
 */
class FrameworkException
    extends \Exception
{
    private $_field;

    /**
     * @see http://php.net/manual/en/language.\Exceptions.extending.php
     * @see http://stackoverflow.com/questions/4049869/php-\Exceptions-extra-parameters
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     * @param null $field
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null, $field = null)
    {
        /**
         * @todo Nicely decorate the Error Messages
         */
        $this->_field = $field;
        parent::__construct($message, $code, $previous);
    }
}