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
        $item = $this->getModel('Item');
		$usuario->__set('id', $_SESSION['id']);

        $this->view->title = 'Timeline';
        $item->__set('userId', $_SESSION['id']);

        $userItens = $item->userItensByDate();
        $this->view->userItens = $userItens;

        $this->render('timeline');

    }

    public function registerSuccess() {
        $this->view->title = 'Sucesso!';
		$this->render('register-success');
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


        $images = $_FILES['itemImages'];
        $postFolder = 'post' . time() * rand();

        $_UP['folder'] = '../public/images/' . $_SESSION['id'] . '/' . $postFolder . '/';
        $_UP['size'] = 5 * 1024 * 1024;
        $_UP['extensions'] = array('png', 'jpg', 'jpeg', 'gif');


        if( isset($images['name']) && isset($_POST['name']) && isset($_POST['value'])) {
      
            $total_files = count($images['name']);
            
            for($key = 0; $key < $total_files; $key++) {

                $imageTmp = explode('.', $images['name'][$key]);
                $extension = strtolower(end($imageTmp));

                if ($_UP['size'] < $images['size'][$key] || $images['size'][$key] == '') {

                    $this->view->status =  "Tamanho de imagem excede o permitido.";

                } else if (!!array_search($extension, $_UP['extensions'])) {

                    if(!file_exists('../public/images/' . $_SESSION['id'] .'/')) {
                        mkdir('../public/images/' . $_SESSION['id'] .'/', 0740, true);
                    }
            
                    if(!file_exists('../public/images/' . $_SESSION['id'] . '/' . $postFolder . '/')) {
                        mkdir('../public/images/' . $_SESSION['id'] . '/' . $postFolder . '/', 0740, true);
                    }

                    $finalName = time() . $key . '.' . $extension;
                    move_uploaded_file($images['tmp_name'][$key], $_UP['folder'] . $finalName);

                }  else {

                    $this->view->status = "Extensão de imagem inválida.";

                }
                
                if(($key + 1) === $total_files && isset($finalName)) {
                    $item->__set('name', $_POST['name']);
                    $item->__set('description', $_POST['description']);
                    $item->__set('value', $_POST['value']);
                    $item->__set('anouncePath', $_UP['folder']);
                    $item->__set('userId', $_SESSION['id']);
            
                    $item->itemSave();
                    header('Location: /register-item?status=success');
                }
              
              }
            }

        $this->view->title = 'Novo anúncio';
        $this->render('register-item');
    }
    
}

?>