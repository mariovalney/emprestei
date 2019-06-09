<?php

namespace App\Exceptions;

use Exception;

class NotCallableException extends HttpException
{
    /**
     * Constructor
     *
     * @param string  $callback
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct($callback, int $code = 0, $previous = null)
    {
        if (! is_string($callback)) {
            $callback = print_r($callback, true);
        }

        $message = 'Callback [' . $callback . '] is invalid.';

        parent::__construct(404, $message, $code, $previous);
    }
}
