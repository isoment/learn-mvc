<?php

namespace app\core;

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

        // If there is no ? we can return the path as is
        if ($position === false) {
            return $path;
        }

        // Return everything in the string before the postion
        return substr($path, 0, $position);
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}