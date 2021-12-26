<?php


namespace jddev2381\phpmvc\form;

use jddev2381\phpmvc\Model;

/**
 * Class Form
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\form
 */

 class Form {

    public static function begin($action, $method) {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end() {
        echo '</form>';
    }

    public function field(Model $model, $attribute) {
        return new InputField($model, $attribute);
    }


 }