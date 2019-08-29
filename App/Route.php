<?php

namespace App;

class Route {

    public function __construct() {
        $this->initRoutes();
    }

    protected function initRoutes() {

        $routes['home'] = array (
            'route' => '/index',
            'controller' => 'indexController',
            'action' => 'index'
        );

        $routes['sobre_nos'] = array (
            'route' => '/about_us',
            'controller' => 'indexController',
            'action' => 'aboutUs'
        );

        $this->routes = $routes;

    }

}


?>