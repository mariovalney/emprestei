<?php

namespace App\Http;

use App\Exceptions\ViewNotFoundException;

class Response
{
    /**
     * The status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * The view
     *
     * @var string
     */
    private $view;

    /**
     * Constructor
     */
    public function __construct(int $statusCode = 200)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Render the view
     */
    public function render()
    {
        $file = VIEW_DIR . DS . $this->view . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }

        if (! DEBUG) return;

        throw new ViewNotFoundException($this->view);
    }

    /**
     * Set view
     *
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = (string) $view;
    }

    /**
     * Get view
     *
     * @return string $view
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set statusCode
     *
     * @param string $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;
    }

    /**
     * Get statusCode
     *
     * @return string $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
