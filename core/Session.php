<?php
declare(strict_types=1);

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {   
        session_start();

        // Get all the flash messages or if there are none set
        // an empty array
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        // Iterate over messages and mark each of them to be removed
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        // Setting the modified flash messages back into the session
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     *  Set a flash message
     * 
     *  @param string $key
     *  @param string $message
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     *  Get a flash message
     * 
     *  @param string $key
     *  @return mixed
     */
    public function getFlash($key) : mixed
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     *  Set the session information
     * 
     *  @param string $key
     *  @param string $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     *  Get the session information by key
     * 
     *  @param string $key
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     *  Remove information from session by key
     *  
     *  @param string $key
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     *  Destructor is called when the object is destroyed
     */
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}