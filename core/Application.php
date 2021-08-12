<?php

namespace app\core;

/**
 *  Class Application
 * 
 *  @package app\core
 */
class Application 
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }
}