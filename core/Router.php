<?php

namespace app\core;

/**
 *  Router
 * 
 *  @package app\core
 */
class Router
{
    public Request $request;

    // n1
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     *  A get request for a route
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     *  Get the path, request method and the callback
     */
    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();

        // Find the given callback in the routes array above
        // or set it to false.
        $callback = $this->routes[$method][$path] ?? false;

        // If there is no callback then there is no route for
        // for what was entered.
        if ($callback === false) {
            echo "Not found";
            exit;
        }

        // Execute the callback
        echo call_user_func($callback);
    }
}