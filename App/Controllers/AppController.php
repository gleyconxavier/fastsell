<?php

namespace App\Controllers;

use App\Connection;

class AppController extends Connection {

    protected $view;

    public function __construct() {
        $this->view = new \stdClass();
    }

    public function timeline() {

		$this->authValid();
			
		$usuario = $this->getModel('User');
		$usuario->__set('id', $_SESSION['id']);

        $this->view->title = 'Timeline';
		$this->render('timeline');

    }

    public static function getModel($model) {
		$class = "\\App\\Models\\".ucfirst($model);
		$db = Connection::getDb();

		return new $class($db);
    }
    
    protected function render($view, $layout = 'layout') {

        $this->view->page = $view;

        $tplPath = "../App/Templates/" . $layout . ".phtml";
        $viewPath = '../App/Views/index/' . $view . '.phtml';

        if(file_exists($tplPath)) {

            require_once $tplPath;


		} else {

            // require_once  $viewPath;
            echo "Ocorreu algo com o template";
		}

    }

    protected function content() {

        $classAtual = get_class($this);

		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

		$classAtual = strtolower(str_replace('Controller', '', $classAtual));

        require_once "../App/Views/" . $classAtual . "/" . $this->view->page . ".phtml";
        
	}

    public function authValid() {

        session_start();
        
		// if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['name']) || $_SESSION['name'] == '') {
		// 	header('Location: /?login=erro');
		// }	

	}
    
}
?>