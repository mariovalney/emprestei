<?php

namespace App\Exceptions;

class ClassNotFoundException extends FileNotFoundException
{
    /**
     * Constructor call FileNotFoundException by code
     *
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct($class, $type = '', $code = 0, $previous = null)
    {
        $type = 'class ' . ucfirst($type);
        $type = trim($type);

        parent::__construct($class, $type, $code, $previous);
    }
}
