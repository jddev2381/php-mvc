<?php


namespace jddev2381\phpmvc;

use jddev2381\phpmvc\Request;
use jddev2381\phpmvc\Response;
use jddev2381\phpmvc\exceptions\NotFoundException;

/**
 * Class Router
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router Constructor
     * 
     * @param \jddev2381\phpmvc\Request $request
     * @param \jddev2381\phpmvc\Response $response
     */

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false) {
            throw new NotFoundException();
        }
        if(is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if(is_array($callback)) {
            /** @var \jddev2381\phpmvc\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }
    
}