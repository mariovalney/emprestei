<?php

namespace App\Support\Facades;

use RuntimeException;

class Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        throw new \RuntimeException('You should implement method getFacadeClass() for Facades');
    }

    /**
     * Create a object.
     *
     * @return string
     */
    protected static function create()
    {
        $class = static::getFacadeClass();
        return new $class();
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        return static::create()->$method(...$args);
    }
}
