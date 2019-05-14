<?php

namespace App\Exceptions;

class NotFoundException extends HttpException
{
    /**
     * Constructor call HttpException by code
     *
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }
}
