<?php

namespace App\Http;

use App\Exceptions\NotFoundException;
use App\Exceptions\ClassNotFoundException;

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
     * @throws ClassNotFoundException
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
                $callback = explode('@', $route->callback);

                $class = 'App\Controllers\\' . $callback[0];
                if (! class_exists($class)) {
                    throw new ClassNotFoundException($class, 'Controller');
                }

                $route->callback = [
                    new $class(),
                    ($callback[1] ?? '') ?: 'index',
                ];
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
