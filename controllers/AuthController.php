<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\User;

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
        $this->setLayout('auth');

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
        $user = new User;

        if ($request->isPost()) {
        
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                return 'Success';
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
}