<?php
declare(strict_types=1);

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules() : array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels() : array
    {
        return [
            'email' => 'Your Email',
            'password' => 'Password'
        ];
    }

    /**
     *  Method to login a user
     * 
     *  @return bool
     */
    public function login() : bool
    {
        // Find a user with the email
        $user = User::findOne(['email' => $this->email]);

        // If the email doesnt exist...
        if (!$user) {
            $this->addError('email', 'User does not exist');

            return false;
        }

        // If the password is incorrect...
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');

            return false;
        }

        // echo '<pre>';
        // var_dump($user);
        // echo '</pre>';
        // exit;

        return Application::$app->login($user);
    }
}