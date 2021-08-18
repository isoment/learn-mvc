<?php
declare(strict_types=1);

namespace app\core;

class Application 
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;

    public function __construct($rootPath)
    {
        // Instead of $this we can refer to static properties with self:: 
        self::$ROOT_DIR = $rootPath;
        // We want the option to call methods from Application class anywhere
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     *  Run the application
     */
    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     *  Controller getter
     * 
     *  @return \app\core\Controller
     */
    public function getController() : Controller
    {
        return $this->controller;
    }

    /**
     *  Controller setter
     * 
     *  @param \app\core\Controller $controller
     */
    public function setController(Controller $controller) : void
    {
        $this->controller = $controller;
    }
}