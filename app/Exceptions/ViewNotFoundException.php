<?php

namespace App\Exceptions;

class ViewNotFoundException extends FileNotFoundException
{
    /**
     * Constructor call FileNotFoundException by code
     *
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct($class, $code = 0, $previous = null)
    {
        parent::__construct($class, 'view', $code, $previous);
    }
}
