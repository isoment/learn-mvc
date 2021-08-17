<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    /**
     *  Login action
     * 
     *  @param app\core\Request $request
     *  @return string
     */
    public function login(Request $request) : string
    {
        return $this->render('login');
    }

    /**
     *  Register action
     * 
     *  @param app\core\Request $request
     *  @return string
     */
    public function register(Request $request) : string
    {
        if ($request->isPost()) {
            var_dump($request->getBody());
            return 'Handle submitted data';
        }

        return $this->render('register');
    }
}