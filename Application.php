<?php

namespace jddev2381\phpmvc;

use jddev2381\phpmvc\Router;
use jddev2381\phpmvc\Request;
use jddev2381\phpmvc\Response;
use jddev2381\phpmvc\db\Database;
use jddev2381\phpmvc\Session;
use jddev2381\phpmvc\db\DbModel;
use jddev2381\phpmvc\View;

/**
 * Class Application
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */

class Application {

    public string $layout = 'main-layout';
    public static string $ROOT_DIR;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public static Application $app;
    public ?Controller $controller = null;
    public View $view;
    
    public function __construct($rootPath, array $config) {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest() {
        return !self::$app->user;
    }

    public function run() {
        try {
            echo $this->router->resolve();
        } catch(\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', ['exception' => $e]);
        }

    }

    public function getController(): \jddev2381\phpmvc\Controller {
        return $this->controller;
    }

    /**
     * @param \jddev2381\phpmvc\Controller $controller
     */
    public function setController(\jddev2381\phpmvc\Controller $controller): void {
        $this->controller = $controller;
    }

    public function login(UserModel $user) {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout() {
        $this->user = null;
        $this->session->remove('user');
    }

}