<?php

namespace App\Support\Facades;

class Helper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Support\Helpers\Helper';
    }
}
