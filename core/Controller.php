<?php
declare(strict_types=1);

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     *  @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    /**
     *  Set the layout to be used
     *  
     *  @param string $layout
     */
    public function setLayout(string $layout) 
    {
        $this->layout = $layout;
    }

    /**
     *  Render the view and pass in parameters
     * 
     *  @param string $view
     *  @param array $params
     * 
     *  @return string
     */
    public function render(string $view, array $params = []) : string
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }
}