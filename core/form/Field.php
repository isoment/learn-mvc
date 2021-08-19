<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     *  A built in PHP magic method to convert an object into a string.
     *  When using an object as if it were a string, PHP will automatically call this.
     */
    public function __toString()
    {
        return sprintf('
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">%s</label>
                <input type="text" name="%s" value="%s"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                              focus:outline-none focus:shadow-outline%s">
                <div class="text-red-400 font-bold text-xs mt-2">
                    %s
                </div>
            </div>
        ', $this->attribute, 
           $this->attribute,
           $this->model->{$this->attribute},
           $this->model->hasError($this->attribute) ? ' border-red-400 bg-red-50' : '',
           $this->model->getFirstError($this->attribute)
        );
    }
}