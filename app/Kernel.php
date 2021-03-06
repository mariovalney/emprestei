<?php

namespace App;

use App\Exceptions\HttpException;
use App\Http\Router;
use App\Support\Database\Migrator;
use App\Support\FacadeLoader;
use App\Support\Facades\Response;
use App\Support\Facades\Helper;
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
        session_start();

        FacadeLoader::init();
        Helper::includeAll();

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
        $migrator = new Migrator();
        $migrator->run();

        try {
            $requestUri = $_SERVER['REQUEST_URI'];
            $requestUri = explode('?', $requestUri);

            $this->router->execute($requestUri[0]);
        } catch (HttpException $e) {
            if (! DEBUG) {
                Response::abort(404);
                return;
            }

            // Rethrow if debugging
            throw $e;
        }
    }
}
