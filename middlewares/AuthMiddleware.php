<?php


namespace jddev2381\phpmvc\middlewares;

use jddev2381\phpmvc\Application;
use jddev2381\phpmvc\exceptions\ForbiddenException;
/**
 * Class AuthMiddleware
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\middlewares
 */

class AuthMiddleware extends BaseMiddleware {

    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }

    public function execute() {
        if(Application::isGuest()) {
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
    
}