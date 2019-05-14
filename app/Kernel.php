<?php

namespace App;

use App\Database\Migrator;
use App\Database\Mysql;
use App\Http\Router;
use App\Http\Response;
use App\Exceptions\HttpException;
use Exception;

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
     * A database instance
     *
     * @var App\Http\Router
     */
    private $router;

    /**
     * Prepare the application
     *
     * @return
     */
    public function __construct()
    {
        $this->db = new Mysql();
        $this->router = new Router();
    }

    /**
     * Retrieve a instance
     *
     * @return
     */
    public static function getInstance()
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

        try {
            $this->router->execute('/');
        } catch (HttpException $e) {

            $response = new Response($e->getStatusCode());
            $response->setView('404');
            $response->render();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}
