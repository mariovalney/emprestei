<?php

namespace App\Http;

use App\Exceptions\NotFoundException;

class Router
{
    /**
     * The configured routes
     *
     * @var array
     */
    private $routes = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        /**
         * Reading the routes
         */
        $file = CONFIG_DIR . DS . 'routes.php';
        if (! file_exists($file)) {
            die('You should configure your routes in routes.php');
        }

        $routes = require_once($file);

        foreach ($routes as $route => $callback) {
            $params = [];
            $pattern = '/^';

            $route = trim($route, '/');
            $route = explode('/', $route);
            foreach ($route as $slug) {
                if (preg_match('/{.+}/', $slug, $matches)) {
                    $params[] = substr($slug, 1, -1);
                    $slug = '(.*)';
                }

                $pattern .= $slug . '\/';
            }

            $pattern .= '$/i';

            $route = implode('.', $route);
            if ($route === '.') {
                $route = 'index';
            }

            $this->routes[] = (object) [
                'pattern'  => $pattern,
                'callback' => $callback,
                'params'   => $params,
            ];
        }
    }

    /**
     * Runa  route
     *
     * @param  string $url
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function execute($url) {
        $url = trim($url, '/') . '/';

        foreach ($this->routes as $route) {
            if (! preg_match($route->pattern, $url, $params)) {
                continue;
            }

            // Remove the first
            array_shift($params);

            $data = [];
            foreach ($params as $key => $param) {
                if (empty($route->params[ $key ])) {
                    continue;
                }

                $data[ $route->params[ $key ] ] = $param;
            }

            // Check for 'ControllerClass@methodName'
            if (is_string($route->callback)) {
                $route->callback = explode('@', $route->callback);

                $route->callback[0] = 'App\Controllers\\' . $route->callback[0];
                if (count($route->callback) < 2) {
                    $route->callback[1] = 'index';
                }
            }

            if (! is_callable($route->callback)) {
                return;
            }

            $request = new Request($url, $data, $route);
            return call_user_func($route->callback, $request);
        }

        throw new NotFoundException($url, 404);
    }
}
