<?php
declare(strict_types=1);

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
    public const RULE_UNIQUE = 'unique';

    /**
     *  Store all the validation errors
     */
    public array $errors = [];

    /**
     *  Load the data passed from the controller and assign it
     *  to model properties if they exist.
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
     *  An abstract class can only be used on the child class
     * 
     *  @return array
     */
    abstract public function rules() : array;

    /**
     *  Get the labels for the inputs
     * 
     *  @return array
     */
    public function labels() : array
    {
        return [];
    }

    /**
     *  Get a label
     */
    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

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

                // If the rule name is an array.. ie [self::RULE_MIN, 'min' => 1]
                // only get the first element, the name.
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);

                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];

                    $uniqueAttr = $rule['attribute'] ?? $attribute;

                    $tableName = $className::tableName();

                    $sql = "SELECT * FROM $tableName WHERE $uniqueAttr = :attribute";

                    $statement = Application::$app->database->prepare($sql);

                    $statement->bindValue(":attribute", $value);

                    $statement->execute();

                    $record = $statement->fetch();

                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /**
     *  Store an error with a custom message
     *  
     *  @param string $attribute
     *  @param string $message
     */
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     *  Store an error in the errors property
     * 
     *  @param string $attribute
     *  @param string $rule
     *  @param array $params
     */
    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        // If there is a rule
        $message = $this->errorMessages()[$rule] ?? '';

        // If there are parameters, ie $param = ['min' => 8]
        // replace the {} in message with the value in the parameter
        foreach($params as $key => $value) {
            $message = str_replace("{{$key}}", (string) $value, $message);
        }

        // Populate the errors property with messages
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
            self::RULE_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    /**
     *  Determine if there are errors for a given attribute
     * 
     *  @param string $attribute
     *  @return mixed
     */
    public function hasError(string $attribute) : mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     *  Get the first error message
     * 
     *  @param string $attribute
     *  @return mixed
     */
    public function getFirstError(string $attribute) : mixed
    {
        return $this->errors[$attribute][0] ?? false;
    }
}