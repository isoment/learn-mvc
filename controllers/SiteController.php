<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{   
    public function home()
    {
        $params = [
            'name' => 'Random User'
        ];

        return $this->render('home', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public static function handleContact()
    {
        return 'Handling submitted data';
    }
}