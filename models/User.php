<?php
declare(strict_types=1);

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';

    /**
     *  Specify the table name we are using
     * 
     *  @return string
     */
    public function tableName(): string
    {
        return 'users';
    }

    /**
     *  Register a user
     */
    public function register()
    {
        return $this->save();
    }

    /**
     *  The rules we want to use for the model
     * 
     *  @return array
     */
    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [
                self::RULE_REQUIRED, 
                [self::RULE_MIN, 'min' => 8],
                [self::RULE_MAX, 'max' => 24]
            ],
            'passwordConfirm' => [
                self::RULE_REQUIRED, 
                [self::RULE_MATCH, 'match' => 'password']
            ],
        ];
    }

    /**
     *  The model attributes we want to persist in the database
     * 
     *  @return array
     */
    public function attributes(): array
    {
        return ['firstName', 'lastName', 'email', 'password'];
    }
}