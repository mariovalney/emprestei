<?php

namespace App\Support;

class Logger
{
    /**
     * Avoid construct
     */
    private function __construct() {}

    /**
     * Avoid Cloning
     */
    private function __clone() {}

    /**
     * Avoid Unserialize
     */
    private function __wakeup() {}

    /**
     * Retrieve a instance
     *
     * @return
     */
    public static function error($message)
    {
        if (defined('DEBUG') && DEBUG) {
            print_r($message);
        }

        error_log($message);
    }
}
