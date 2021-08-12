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
     *  We need to determine the current path and the current method,
     *  based on this we execute the callback and output the results.
     */
    public function resolve()
    {
        $this->request->getPath();
    }
}