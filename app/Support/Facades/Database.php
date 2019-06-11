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
        return 'App\Support\Database\Mysql';
    }

    /**
     * Create a object.
     *
     * @return string
     */
    protected static function create()
    {
        return static::getFacadeClass()::getInstance();
    }
}
