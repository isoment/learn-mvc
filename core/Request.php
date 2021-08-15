<?php
declare(strict_types=1);

namespace app\core;

class Request
{
    /**
     *  A method to get the URI Path.
     * 
     *  @return string
     */
    public function getPath() : string
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

    /**
     *  The method type of the request
     * 
     *  @return string
     */
    public function getMethod() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}