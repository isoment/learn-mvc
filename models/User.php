<?php
declare(strict_types=1);

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';

    /**
     *  Specify the table to use
     * 
     *  @return string
     */
    public static function tableName() : string
    {
        return 'users';
    }

    /**
     *  Get the primary key
     */
    public static function primaryKey() : string
    {
        return 'id';
    }

    /**
     *  Override the save method in DbModel class
     * 
     *  @return boolean
     */
    public function save() : bool
    {
        $this->status = self::STATUS_INACTIVE;

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Call the save() method in DbModel
        return parent::save();
    }

    /**
     *  The rules to use for the model
     * 
     *  @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE, 
                    'class' => self::class, 
                    'attribute' => 'email'
                ]
            ],
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
     *  The model attributes to persist in the database
     * 
     *  @return array
     */
    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }

    /**
     *  The label names for the form inputs
     */
    public function labels() : array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm Password'
        ];
    }

    /**
     *  Display the users name
     */
    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}