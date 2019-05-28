<?php

namespace App\Support\Facades;

class Router extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Http\Router';
    }

    /**
     * Show a view as response
     *
     * @param  string $name
     * @return void
     */
    public static function current()
    {
        $response = static::create();
        return $response->getCurrentRoute();
    }
}
