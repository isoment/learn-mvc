<?php
declare(strict_types=1);

namespace app\core;

use Exception;

class Application 
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Session $session;
    public Response $response;
    public static Application $app;
    public ?Controller $controller = null;
    public Database $database;
    // The ? indicates this might be null
    public ?DbModel $user;
    public string $userClass;
    public string $layout = 'main';

    public function __construct($rootPath, array $config)
    {
        // Set the user class for the application, don't want to reference User class here
        // since it's outside the core. Pass it in from config in index.php.
        $this->userClass = $config['userClass'];
        // Instead of $this we can refer to static properties with self:: 
        self::$ROOT_DIR = $rootPath;
        // We want the option to call methods from Application class anywhere
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        // Initialize to prevent error when accessing route with just a string param
        // referencing a view.
        $this->controller = new Controller();
        $this->database = new Database($config['db']);

        $primaryValue = $this->session->get('user');

        // If there is a user set in session...
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    /**
     *  Check if the user doesn't exist
     */
    public static function isGuest()
    {
        return ! self::$app->user;
    }

    /**
     *  Run the application
     */
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
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

    /**
     *  Login user
     * 
     *  @param \app\core\DbModel
     */
    public function login(DbModel $user)
    {
        $this->user = $user;

        $primaryKey = $user->primaryKey();

        // $user->id is the result if the primary key column is id
        $primaryValue = $user->{$primaryKey};

        $this->session->set('user', $primaryValue);

        return true;
    }

    /**
     *  Logout user
     */
    public function logout()
    {
        $this->user = null;

        $this->session->remove('user');
    }
}