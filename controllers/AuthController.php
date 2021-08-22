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
        $registerModel = new User;

        if ($request->isPost()) {
        
            $registerModel->loadData($request->getBody());

            if ($registerModel->validate() && $registerModel->register()) {
                return 'Success';
            }

            // var_dump($registerModel->errors);

            $this->setLayout('auth');
            
            return $this->render('register', [
                'model' => $registerModel
            ]);
        }

        $this->setLayout('auth');

        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}