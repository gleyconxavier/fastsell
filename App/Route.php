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

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
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