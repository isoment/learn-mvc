<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    /**
     *  Create the form opening tag
     * 
     *  @param string $action
     *  @param string $method
     *  @param string $class
     * 
     *  @return app\core\form\Form
     */
    public static function begin(string $action, string $method, string $class) : Form
    {
        echo sprintf(
            '<form action="%s" method="%s" class="%s">',
            $action,
            $method,
            $class
        );

        return new Form();
    }

    /**
     *  Create the closing form tag
     */
    public static function end()
    {
        echo '</form>';
    }

    /**
     *  Create a new field passing in the model and attribute
     * 
     *  @param app\core\Model $model
     *  @param string $attribute
     * 
     *  @return app\core\form\Field
     */
    public function field(Model $model, $attribute)
    {
        return new Field($model, $attribute);
    }
}