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
    public static function view($name, $data = [])
    {
        $response = static::create();
        $response->setView($name);
        $response->setData($data);

        return $response->render();
    }

    /**
     * Redirect to url
     *
     * @param  string $name
     * @return void
     */
    public static function redirect($url)
    {
        header("Location: " . url($url));
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
