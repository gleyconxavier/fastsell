<?php

namespace App\Controllers;

use App\Connection;

class IndexController extends Connection {

    protected $view;

    public function __construct() {
        $this->view = new \stdClass();
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

    public function index() {
        $this->view->title = 'Home';
        $this->render('index');

    }

    public function login() {
        $this->view->title = 'Entrar';
        $this->render('login');
    }

    public function aboutus(){
        $this->view->title = 'Sobre nós';
        $this->render('about-us');
    }

    public function register() {
        $this->view->title = 'Cadastrar';
        $this->view->registerError = '';
        $this->render('register');
    }

    public function registerUser() {

		$user = $this->getModel('User');

        $user->__set('name', $_POST['name']);
        $user->__set('surname', $_POST['surname']);
		$user->__set('email', $_POST['email']);
        $user->__set('passwd', md5($_POST['passwd']));
        $user->__set('username', $_POST['username']);
		
		if($user->validUser() && count($user->getUserByEmail()) == 0) {
		
				$user->save();
                $this->view->title = 'Sucesso';
				$this->render('register-user');

		} else {

			$this->view->user = array(
				'name' => $_POST['name'],
				'email' => $_POST['email'],
				'passwd' => $_POST['passwd'],
			);

			$this->view->registerError = true;
            $this->view->title = 'Erro';
			$this->render('register');
		}

    }

    public static function getModel($model) {
        $class = "\\App\\Models\\".ucfirst($model);
        $conn = Connection::getDb();

        return new $class($conn);
    }
    
}

?>