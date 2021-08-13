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
     *  Resolve the route, to do this we need to get the path. method
     *  and then determine if a callback or string referencing a view is
     *  passed in.
     */
    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();

        // Find the given callback in the routes array above
        // or set it to false.
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            return "Not found";
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // Execute the callback
        return call_user_func($callback);
    }

    /**
     *  Renter a view
     */
    public function renderView($view)
    {
        include_once __DIR__ . "/../views/$view.php";
    }
}