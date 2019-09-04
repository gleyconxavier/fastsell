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
        
		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['name']) || $_SESSION['name'] == '') {
			header('Location: /?login=erro');

        }
    }

    public function registerItem() {
        $this->view->title = 'Novo anúncio';
        $this->render('register-item');
    }

    public function authItem() {
        $this->authValid();

        $item = $this->getModel('Item');
        print_r($_SESSION);
        $image = $_FILES['itemImage'];

        if(!file_exists('../App/images/' . $_SESSION['id'] .'/')) {
            mkdir('../App/images/' . $_SESSION['id'] .'/', 0740, true);
        }

        $_UP['folder'] = '../App/images/' . $_SESSION['id'] . '/post' . time();
        $_UP['size'] = 1024 * 1024 * 100;
        $_UP['extensions'] = array('png', 'jpg', 'jpeg', 'gif');

        // end only receive a string
        $imageTmp = explode('.', $image['name']);
        $extension = strtolower(end($imageTmp));

        if(array_search($extension, $_UP['extensions']) === false) {
            echo "Extensão de imagem inválida.";
        } elseif ($_UP['size'] < $image['size']) {
            echo  "Tamanho de imagem excede o permitido.";
        } else {
            $finalName = time() . '.' . $extension;
        }

        if(move_uploaded_file($image['tmp_name'], $_UP['folder'] . $finalName)) {
            echo "Imagem cadastrada.";
        } else {
            echo "Ocorreu um erro durante o upload :(";
        }

        $item->__set('name', $_POST['name']);
		$item->__set('description', $_POST['description']);
        $item->__set('value', $_POST['value']);
        $item->__set('anouncePath', $_UP['folder']);
        $item->__set('userId', $_SESSION['id']);

        $item->itemSave();

        $this->view->title = 'Novo anúncio';
        $this->render('register-item');
    }

    public function itemSave() {
        $this->authValid();


    }
    
}

?>