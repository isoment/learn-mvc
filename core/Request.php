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
    public function method() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     *  If the method is a get request
     * 
     *  @return bool
     */
    public function isGet() : bool
    {
        return $this->method() === 'get';
    }

    /**
     *  If the method is a post request
     * 
     *  @return bool
     */
    public function isPost() : bool
    {
        return $this->method() === 'post';
    }

    /**
     *  Get request body
     * 
     *  @return array
     */
    public function getBody() : array
    {
        $body = [];

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}