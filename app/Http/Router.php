<?php

namespace App\Http;

use App\Exceptions\NotFoundException;
use App\Exceptions\NotCallableException;
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
     * Keep data to application
     *
     * @var array
     */
    private static $router = [
        'route' => null,
        'params' => [],
        'url' => '',
        'path' => '',
    ];

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

        foreach ((array) $routes as $route => $callback) {
            $params = [];
            $pattern = '/^';

            $route = trim($route, '/');
            $route = explode('/', $route);
            foreach ($route as $slug) {
                if (preg_match('/{.+}/', $slug, $matches)) {
                    $params[] = substr($slug, 1, -1);
                    $slug = '([^\/]*)';
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
     * Run a route
     *
     * @param  string $url
     *
     * @throws NotCallableException
     *
     * @return void
     */
    public function execute($url) {
        $url = trim($url, '/') . '/';

        $data = $this->getRouteData($url);

        if (empty($data['callback'])) {
            $data['callback'] = [];
        }

        // Try a callback by request type (only if is not a clousure)
        if (is_array($data['callback']) && ! empty($data['callback'][1])) {
            $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
            $method = ucfirst(strtolower($method));

            $callback = [
                $data['callback'][0],
                $data['callback'][1] . $method,
            ];

            if (is_callable($callback)) {
                $data['callback'] = $callback;
            }
        }

        // Check is callable
        if (! is_callable($data['callback'])) {
            throw new NotCallableException($data['callback']);
        }

        $request = new Request($url, $data['params']);
        return call_user_func($data['callback'], $request);
    }

    /**
     * Return the current router data
     *
     * @return array
     */
    public function getCurrentRoute()
    {
        return (object) self::$router;
    }

    /**
     * Find the callback for route
     *
     * @throws ClassNotFoundException
     * @throws NotFoundException
     *
     * @return array
     */
    private function getRouteData($url)
    {
        // Restart current router data
        self::$router = [
            'route' => null,
            'params' => [],
            'url' => $this->getBaseUrl(),
            'path' => $url,
        ];

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

            /**
             * Data for application
             */
            self::$router['route'] = $route;

            return [
                'callback' => $route->callback,
                'params' => $data,
            ];
        }

        throw new NotFoundException($url, 404);
    }

    /**
     * Get a absolute URL from path
     *
     * @param  string $url
     * @return string
     */
    private function getBaseUrl()
    {
        $schema = ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://';
        $domain = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '' );

        $domain = rtrim($domain, '/');

        return $schema . $domain;
    }
}
