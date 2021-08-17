<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{   
    /**
     *  Action for the home view
     * 
     *  @return string
     */
    public function home() : string
    {
        $params = [
            'name' => 'Random User'
        ];

        return $this->render('home', $params);
    }

    /**
     *  Action for the contact view
     * 
     *  @return string
     */
    public function contact() : string
    {
        return $this->render('contact');
    }

    /**
     *  @param app\core\Request $request
     */
    public static function handleContact(Request $request) : string
    {
        $body = $request->getBody();

        var_dump($body);

        return 'Handling submitted data';
    }
}