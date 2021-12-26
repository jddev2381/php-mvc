<?php


namespace jddev2381\phpmvc\form;

use jddev2381\phpmvc\Model;

/**
 * Class Field
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\form
 */


 class InputField extends BaseField {

    public const TYPE_TEXT      = 'text';
    public const TYPE_EMAIL     = 'email';
    public const TYPE_DATE      = 'date';
    public const TYPE_PASSWORD  = 'password';
    public const TYPE_NUMBER    = 'number';

    public string $type;

    public function __construct(Model $model, string $attribute) {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function passwordField() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function dateField() {
        $this->type = self::TYPE_DATE;
        return $this;
    }

    public function emailField() {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function numberField() {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }


     public function renderInput(): string
     {
         return sprintf('<input class="%s" type="%s" name="%s" placeholder="%s" value="%s">', $this->model->hasErrors($this->attribute) ? 'invalid' : '',
             $this->type,
             $this->attribute,
             $this->model->getLabel($this->attribute),
             $this->model->{$this->attribute},
         );
     }
 }