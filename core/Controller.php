<?php

namespace app\core;

class Controller
{
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
}