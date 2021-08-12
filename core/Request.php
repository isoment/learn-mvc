<?php

namespace app\core;

/**
 *  Class Request
 * 
 *  @package app\core
 */
class Request
{
    /**
     *  A method to get the URI Path.
     */
    public function getPath()
    {
        // Get the URI path if present or '/'
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Find the position of the ? if present
        $position = strpos($path, '?');

        var_dump($position);
    }

    public function getMethod()
    {

    }
}