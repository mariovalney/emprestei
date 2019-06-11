<?php

namespace App\Support\Database;

use App\Support\Contracts\Database;
use App\Exceptions\DatabaseDriverNotFound;

class DatabaseFactory
{
    /**
     * Factoring
     */
    public function createDatabase()
    {
        $driver = '';
        if (defined('DB_DRIVER') && DB_DRIVER) {
            $driver = DB_DRIVER;
        }

        $namespace = 'App\Support\Database\Drivers\\';

        $driver = ucfirst(strtolower($driver));
        $driver = $namespace . $driver;

        if (! class_exists($driver) || ! is_subclass_of($driver, Database::class)) {
            throw new DatabaseDriverNotFound($driver);
        }

        return $driver::getInstance();
    }
}
