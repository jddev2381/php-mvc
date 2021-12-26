<?php

namespace jddev2381\phpmvc;

use jddev2381\phpmvc\middlewares\BaseMiddleware;
use jddev2381\phpmvc\middlewares\AuthMiddleware;

/**
 * Class Controller
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */

 class Controller {


    public string $layout = 'main-layout';
    public string $action = '';
    /**
     * @var \jddev2381\phpmvc\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];


    public function setLayout($layout) {
        $this->layout = $layout;
    }


    public function render($view, $params = []): array|bool|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array {
        return $this->middlewares;
    }

 }