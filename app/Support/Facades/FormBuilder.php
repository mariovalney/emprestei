<?php

namespace App\Support\Facades;

class FormBuilder extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'App\Support\Helpers\FormBuilder';
    }
}
