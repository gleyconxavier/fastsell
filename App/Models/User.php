<?php

namespace App\Models;

use App\Connection;
 
 class User extends Connection {

    private $name;
    private $surname;
    private $email;
    private $passwd;
    private $username;
    private $cpf;
    private $avatar;

    protected $db;

	public function __construct(\PDO $db) {
		$this->db = $db;
	}

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function save() {

		$query = "insert into users(name, surname, email, passwd, username, cpf, avatar)
        values(:name, :surname, :email, :passwd, :username)";
        $stmt = $this->db->prepare($query);
        
		$stmt->bindValue(':name', $this->__get('name'));
		$stmt->bindValue(':surname', $this->__get('surname'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':passwd', md5($this->__get('passwd'))); // cript depois
		$stmt->bindValue(':username', $this->__get('username'));
		// $stmt->bindValue(':cpf', $this->__get('cpf'));
        // $stmt->bindValue(':avatar', $this->__get('avatar'));
        $stmt->execute();
        print_r($stmt);
        
        print_r($_POST);

		return $this;
	}

}

?>