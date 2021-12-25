<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;
use app\core\middlewares\AuthMiddleware;

/**
 * Class Controller
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\core
 */

 class Controller {


    public string $layout = 'main-layout';
    public string $action = '';
    /**
     * @var \app\core\middlewares\BaseMiddleware[]
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