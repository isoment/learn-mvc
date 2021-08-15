<?php

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
}