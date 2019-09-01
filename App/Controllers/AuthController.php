<?php

namespace App\Controllers;
use App\Connection;

class AuthController extends Connection {
    
    public function auth() {

        $class = $this::getModel('user');
        $class->save();
        
    }

    public static function getModel($model) {
		$class = "\\App\\Models\\".ucfirst($model);
		$db = Connection::getDb();

		return new $class($db);
	}

    public function sair() {
		session_start();
		session_destroy();
		header('Location: /');
	}
}

?>