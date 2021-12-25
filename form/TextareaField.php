<?php

namespace app\core\form;

class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<textarea class="%s" name="%s" placeholder="%s">%s</textarea>',
            $this->model->hasErrors($this->attribute) ? 'invalid' : '',
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->model->{$this->attribute}
        );
    }
}