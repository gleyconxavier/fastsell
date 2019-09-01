<?php

namespace App\Controllers;

class IndexController {

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
        $this->view->dados = array("Dados", "de", "Teste");
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
        $this->render('register');
    }

    public function registerUser() {

		$usuario = Container::getModel('User');

		$usuario->__set('name', $_POST['name']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('passwd', md5($_POST['passwd']));

		
		if($usuario->registerUser() && count($usuario->getUserByEmail()) == 0) {
		
				$usuario->salvar();

				$this->render('cadastro');

		} else {

			$this->view->usuario = array(
				'name' => $_POST['name'],
				'email' => $_POST['email'],
				'passwd' => $_POST['passwd'],
			);

			$this->view->registerError = true;

			$this->render('register');
		}

	}
}

?>