<?php

namespace app\core;

abstract class Model
{
    /**
     *  Validation rules
     */
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    /**
     *  Store all the validation errors
     */
    public array $errors;

    /**
     *  Load the data passed from the controller
     * 
     *  @param array $data
     */
    public function loadData(array $data)
    {
        // Loop through the data, if the child model has a property with 
        // the same name we assign the value to the property.
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     *  An abstract class can only be used on the child class.
     * 
     *  @return array
     */
    abstract public function rules() : array;

    /**
     *  Validate the data
     * 
     *  @return bool
     */
    public function validate() : bool
    {
        // We can access the rules from our child models 
        // through the abstract class.
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
            }
        }

        return empty($this->errors);
    }

    /**
     *  Store an error in the errors property
     * 
     *  @param string $attribute
     *  @param string $rule
     */
    public function addError(string $attribute, string $rule)
    {
        // If there is a rule
        $message = $this->errorMessages()[$rule] ?? '';

        $this->errors[$attribute][] = $message;
    }

    /**
     *  Method to determine error messages
     *  
     *  @return array
     */
    public function errorMessages() : array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Minimum length {min}',
            self::RULE_MAX => 'Maximum length {max}',
            self::RULE_MATCH => 'Field must be the same as {match}',
        ];
    }
}