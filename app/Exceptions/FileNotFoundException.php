<?php

namespace App\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    /**
     * Constructor
     *
     * @param string  $statusCode
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct(string $file, string $type = 'file', int $code = 0, $previous = null)
    {
        $message = ucfirst($type) . ' [' . $file . '] not found.';

        parent::__construct($message, $code, $previous);
    }
}
