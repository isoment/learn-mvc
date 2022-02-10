<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    /**
     *  @param app\core\Request $request
     *  @param app\core\Response $response
     */
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm;

        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');

                return;
            }
        }

        $this->setLayout('auth');

        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    /**
     *  @param app\core\Request $request
     *  @return string
     */
    public function register(Request $request) : string
    {
        $user = new User;

        if ($request->isPost()) {
        
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Registration successful');

                Application::$app->response->redirect('/');

                return 'Show success page';
            }

            // var_dump($user->errors);

            $this->setLayout('auth');
            
            return $this->render('register', [
                'model' => $user
            ]);
        }

        $this->setLayout('auth');

        return $this->render('register', [
            'model' => $user
        ]);
    }

    /**
     *  @param Request $request
     *  @param Response $response
     */
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}