<?php

namespace App\Http;

class Request
{
    /**
     * The requested URL
     *
     * @var string
     */
    private $url;

    /**
     * The params
     *
     * @var array
     */
    private $params;

    /**
     * Constructor
     */
    public function __construct(string $url, array $params)
    {
        $this->url = $url;
        $this->params = $params;
    }

    /**
     * Return all params
     *
     * @return array
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * Return get params
     *
     * @return array
     */
    public function get($key = '')
    {
        if (empty($key)) {
            return $_GET;
        }

        return $_GET[ $key ] ?? null;
    }

    /**
     * Return post params
     *
     * @return array
     */
    public function post($key = '')
    {
        if (empty($key)) {
            return $_POST;
        }

        return $_POST[ $key ] ?? null;
    }

    /**
     * Return request params
     *
     * @return array
     */
    public function all($key = '')
    {
        if (empty($key)) {
            return $_POST;
        }

        return $_REQUEST[ $key ] ?? null;
    }

    /**
     * Return a input (get or post) by key
     *
     * @return array
     */
    public function input($key)
    {
        return $this->all($key);
    }
}
