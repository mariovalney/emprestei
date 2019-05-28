<?php

if (! function_exists('url')) {
    function url($path, $absolute = true) {
        $router = App\Support\Facades\Router::current();

        $url = ($absolute) ? $router->url : $router->path;
        $url = trim($url, '/') . DS . trim($path, '/');

        return (empty($url)) ? '/' : $url;
    }
}

if (! function_exists('is_current')) {
    function is_current($path) {
        $router = App\Support\Facades\Router::current();

        return trim($path, '/') === trim($router->path, '/');
    }
}
