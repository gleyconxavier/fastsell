<?php

namespace App\Controllers;
use App\Connection;

class AuthController extends Connection {
    	
	public function auth() {
		
		$user = $this->getModel('User');

		$user->__set('email', $_POST['email']);
		$user->__set('passwd', md5($_POST['passwd']));

		$user->auth();

		if($user->__get('id') != '' && $user->__get('name')) {
			
			session_start();

			$_SESSION['id'] = $user->__get('id');
			$_SESSION['name'] = $user->__get('name');

			header('Location: /timeline');

		} else {
			echo "erro na válidação de usuário";
			// header('Location: /?login=error');
		}

	}

    public static function getModel($model) {
		$class = "\\App\\Models\\".ucfirst($model);
		$db = Connection::getDb();

		return new $class($db);
	}

    public function exit() {
		session_start();
		session_destroy();
		header('Location: /');
	}
}

?>