<?php

namespace App\Support\Facades;

class Request extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Http\Request';
    }

    /**
     * Create a object.
     *
     * @return string
     */
    protected static function create()
    {
        return static::getFacadeClass()::last();
    }
}
