<?php

namespace App\Support\Facades;

class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Http\Response';
    }

    /**
     * Show a view as response
     *
     * @param  string $name
     * @return void
     */
    public static function view($name)
    {
        $response = static::create();
        $response->setView($name);

        return $response->render();
    }

    /**
     * Show a view as response
     *
     * @param  string $name
     * @return void
     */
    public static function abort($code)
    {
        $response = static::create();
        $response->setStatusCode($code);
        $response->setView($code);
        $response->render();
    }

}
