<?php

namespace App\Models;

use App\Connection;

class Item extends Connection {
    
    private $id;
    private $userId;
    private $item;
    private $name;
    private $description;
    private $value;
    private $anouncePath;

    public function __construct(\PDO $db) {
        $this->db = $db;
        $this->createTable();
    }

	public function __get($atribute) {
		return $this->$atribute;
	}

	public function __set($atribute, $value) {
		$this->$atribute = $value;
	}

    public function createTable() {

        $query = "CREATE TABLE IF NOT EXISTS `fastsell`.`itens` ( `id` INT NOT NULL AUTO_INCREMENT , `anouncePath` VARCHAR(120) NOT NULL, `name` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , `userId` INT(11) NOT NULL, `value` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function itemSave() {

        $query = "insert into itens(name, description, value, anouncePath, userId)
        values(:name, :description, :value, :anouncePath, :userId)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':description', $this->__get('description'));
        $stmt->bindValue(':value', $this->__get('value'));
        $stmt->bindValue(':anouncePath', $this->__get('anouncePath'));
        $stmt->bindValue(':userId', $this->__get('userId'));
        $stmt->execute();
    }

    public function itemEdit() {

    }

    public function itemDelete() {

    }

    public function itemReturn() {

    }
}