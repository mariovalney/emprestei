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
        return 'App\Http\Request';
    }
}
