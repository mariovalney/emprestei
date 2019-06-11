<?php

namespace App\Support\Facades;

class Database extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Support\Database\DatabaseFactory';
    }

    /**
     * Create a object.
     *
     * @return string
     */
    protected static function create()
    {
        $database = parent::create();
        return $database->createDatabase();
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
