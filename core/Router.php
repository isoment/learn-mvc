<?php
declare(strict_types=1);

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
     * 
     *  @param string $path
     *  @param mixed $callback
     */
    public function get(string $path, mixed $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     *  A post request for a route
     * 
     *  @param string $path
     *  @param mixed $callback
     */
    public function post(string $path, mixed $callback)
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

        $method = $this->request->method();

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

        // If an array [Sample::class, 'method'], the first element will be a string,
        // Instantiate it and reassign back to the $callback array.
        if (is_array($callback)) {
            $instance = new $callback[0];
            Application::$app->controller = $instance;
            $callback[0] = Application::$app->controller;
        }

        // Execute the callback function or if it is an array [SiteController::class, 'home']
        // will try to execute the defined controller action. Also pass in the request so it is
        // available as a parameter in controller actions (methods) when needed.
        return call_user_func($callback, $this->request);
    }

    /**
     *  Render a view
     * 
     *  @param string $view
     *  @param array $params
     * 
     *  @return string
     */
    public function renderView(string $view, array $params = []) : string
    {
        $layoutContent = $this->layoutContent();

        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     *  Layout content method
     * 
     *  @return string
     */
    protected function layoutContent() : string
    {
        $layout = Application::$app->controller->layout;

        ob_start();

        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";

        return ob_get_clean();
    }

    /**
     *  Render only view
     * 
     *  @param string $view
     *  @param array $params
     * 
     *  @return string
     */
    protected function renderOnlyView(string $view, array $params) : string
    {
        // For each parameter we pass we are creating a new
        // variable named $key using $$ that is passed into the view
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once Application::$ROOT_DIR . "/views/$view.php";

        return ob_get_clean();
    }
}