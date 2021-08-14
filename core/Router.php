<?php

namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     *  A get request for a route
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     *  A post request for a route
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
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

        // If there is no route defined...
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        // If there is a view for the argument...
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // Execute the callback or if it is an array [Sample::class, 'method']
        // will try to execute the method on the Object.
        return call_user_func($callback);
    }

    /**
     *  Render a view
     */
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();

        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     *  Render a view
     */
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     *  Layout content method
     */
    protected function layoutContent()
    {
        ob_start();

        include_once Application::$ROOT_DIR . "/views/layouts/main.php";

        return ob_get_clean();
    }

    /**
     *  Render only view
     */
    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once Application::$ROOT_DIR . "/views/$view.php";

        return ob_get_clean();
    }
}