<?php
namespace common;

/**
 * Stop Watch
 *
 * @package Common
 * @author ScallioXTX
 * @url http://www.sitepoint.com/forums/showthread.php?t=727493
 * @see http://www.hulldo.co.uk/web/tutorial/php_load_time/
 * Usage:
 *    $stopwatch = new stopwatch();
 *    ...
 *    echo $seconds = $stopwatch->stop();
 *    echo $seconds = $stopwatch->time_taken();
 */
class stopwatch
{
    private $_starttime;

    function __construct()
    {
        /**
         * Auto initiate the timer
         */
        $this->start();
    }

    /**
     * Begin the timer
     */
    public function start()
    {
        $this->_starttime = $this->current_time();
    }

    /**
     * Finds out the FLOAT value of current time
     */
    private function current_time()
    {
        $current_time = microtime();
        list($microseconds, $seconds) = explode(' ', $current_time);

        return (float)$microseconds + (float)$seconds;
    }

    /**
     * Alias of stopper
     */
    public function time_taken()
    {
        return $this->stop();
    }

    /**
     * Stop the timer
     */
    public function stop()
    {
        $stop_time = $this->current_time();

        return round($stop_time - $this->_starttime, 4);
    }
}
