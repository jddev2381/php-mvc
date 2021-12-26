<?php

namespace jddev2381\phpmvc\form;

use jddev2381\phpmvc\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    abstract public function renderInput(): string;

    /**
     * Field Constructor
     * @param \jddev2381\phpmvc\Model $model
     * @param string          $attribute
     */
    public function __construct(Model $model, string $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString() {
        return sprintf('
            %s 
            <p class="error-msg">%s</p>
        ',
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

}