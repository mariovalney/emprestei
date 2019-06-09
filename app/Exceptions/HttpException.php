<?php

namespace App\Exceptions;

use Exception;

class HttpException extends Exception
{
    /**
     * Status Code HTTP
     *
     * @var int
     */
    private $statusCode;

    /**
     * Constructor
     *
     * @param string  $statusCode
     * @param string  $message
     * @param integer $code
     * @param Exception  $previous
     */
    public function __construct(int $statusCode, string $message = '', int $code = 0, $previous = null)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
