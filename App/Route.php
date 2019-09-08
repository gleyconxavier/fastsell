<?php

namespace App;

class Route {

    private $routes;

    public function __construct() {

        $this->initRoutes();
        $this->run($this->getUrl());

    }

    public function getRoutes() {

        return $this->routes;

    }

    public function setRoutes($routes) {

        $this->routes = $routes;

    }

    public function getUrl() {

        return parse_url(($_SERVER['REQUEST_URI']), PHP_URL_PATH);

    }

    protected function initRoutes() {

        $routes['home'] = array (
            'route' => '/',
            'controller' => 'indexController',
            'action' => 'index'
        );

        $routes['sobre_nos'] = array (
            'route' => '/about-us',
            'controller' => 'indexController',
            'action' => 'aboutUs'
        );

        $routes['login'] = array (
            'route' => '/login',
            'controller' => 'indexController',
            'action' => 'login'
        );

        $routes['register'] = array (
            'route' => '/register',
            'controller' => 'indexController',
            'action' => 'register'
        );

        $routes['registerUser'] = array (
            'route' => '/register-user',
            'controller' => 'indexController',
            'action' => 'registerUser'
        );
        
        $routes['authenticate'] = array (
            'route' => '/auth',
            'controller' => 'authController',
            'action' => 'auth'
        );

        $routes['exit'] = array (
            'route' => '/exit',
            'controller' => 'authController',
            'action' => 'exit'
        );

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
        );

        $routes['userItens'] = array(
			'route' => '/my-itens',
			'controller' => 'AppController',
			'action' => 'userItens'
        );

        $routes['editPost'] = array(
			'route' => '/editPost',
			'controller' => 'AppController',
			'action' => 'editPost'
        );

        $routes['deletePost'] = array(
			'route' => '/deletePost',
			'controller' => 'AppController',
			'action' => 'deletePost'
        );

        $routes['itemEdit'] = array(
			'route' => '/item-edit',
			'controller' => 'AppController',
			'action' => 'itemEdit'
        );
        
        $routes['registerItem'] = array (
            'route' => '/register-item',
            'controller' => 'AppController',
            'action' => 'registerItem'
        );

        $routes['registerSuccess'] = array (
            'route' => '/register-success',
            'controller' => 'AppController',
            'action' => 'registerSuccess'
        );

        $routes['authItem'] = array (
            'route' => '/auth-item',
            'controller' => 'AppController',
            'action' => 'authItem'
        );

        $routes['searchItem'] = array (
            'route' => '/search',
            'controller' => 'AppController',
            'action' => 'searchItem'
        );

        $routes['contact'] = array (
            'route' => '/contact',
            'controller' => 'IndexController',
            'action' => 'contact'
        );

        $this->setRoutes($routes);

    }

    public function run($url) {

        $count = 0;

        foreach ($this->getRoutes() as $key => $route) {

            if($url == $route['route']) {

                $class = "App\\Controllers\\" . ucfirst($route['controller']);

                    $controller = new $class;
                    $action = $route['action'];
                    $controller->$action();
                    break;

            } else {
                $count = $count + 1;
            }
            
        }

        if($count == sizeof($this->routes)) {
            echo "Erro de rota";
            // header('Location: /?erro');
        }


    }

}


?>