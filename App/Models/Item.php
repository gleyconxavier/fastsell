<?php

namespace App\Models;

use App\Connection;

class Item extends Connection {
    
    private $item;

    public function __construct(\PDO $db) {
        $this->db = $db;
        $this->createTable();
    }

    public function __getItem() {
        return $this->item;
    }

    public function __setItem($item) {
        return $this->item = $item;
    }

    public function createTable() {

        $query = "CREATE TABLE IF NOT EXISTS `fastsell`.`itens` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , `value` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function itemSave() {
        $query = "insert into itens(name, description, value, img)
        values(:name, :description, :value, :img)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':description', $this->__get('description'));
        $stmt->bindValue(':value', $this->__get('value'));
    }

    public function itemEdit() {

    }

    public function itemDelete() {

    }

    public function itemReturn() {

    }
}