<?php

namespace App;

use App\Database\Migrator;
use App\Database\Mysql;

class Kernel
{
    /**
     * The instance to Singleton patter
     *
     * @var Kernel
     */
    private static $instance;

    /**
     * A database instance
     *
     * @var App\Database\MySQL
     */
    private $db;

    /**
     * Prepare the application
     *
     * @return
     */
    public function __construct()
    {
        $this->db = new Mysql();
    }

    /**
     * Retrieve a instance
     *
     * @return
     */
    public function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initialize the app
     *
     * @return
     */
    public function init()
    {
        $migrator = new Migrator($this->db);
        $migrator->run();
    }
}
