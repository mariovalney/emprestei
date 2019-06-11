<?php

namespace App\Exceptions;

class DatabaseDriverNotFound extends ClassNotFoundException
{
    /**
     * Constructor
     *
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct($driver, $code = 0, $previous = null)
    {
        parent::__construct($driver, 'database driver', $code, $previous);
    }
}
