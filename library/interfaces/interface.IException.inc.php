<?php
namespace interfaces;

/**
 * Exception Interface
 *
 * @package Interfaces
 */
interface IException
{
        public function __construct($message = null, $code = 0); // \Exception message

    /**
     * Protected methods inherited from \Exception class
     */
    public function getMessage(); // User-defined \Exception code

    public function getCode(); // Source filename

    public function getFile(); // Source line

    public function getLine(); // An array of the backtrace()

    public function getTrace(); // Formatted string of trace

    public function getTraceAsString(); // formatted string for display

/**
     * Override-able methods inherited from \Exception class
     */
    public function __toString();
}
