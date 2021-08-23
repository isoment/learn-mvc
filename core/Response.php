<?php
declare(strict_types=1);

namespace app\core;

class Response 
{
    /**
     *  Set the http status code
     * 
     *  @param int $code
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     *  Redirect to a given URL
     * 
     *  @param string $url
     */
    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}