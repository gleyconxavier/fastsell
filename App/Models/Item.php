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
    private $contact;
    private $username;

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

        $query = "CREATE TABLE IF NOT EXISTS `fastsell`.`itens` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , `value` INT(11) NOT NULL , `anouncePath` VARCHAR(128) NOT NULL ,  `contact` TEXT NOT NULL ,`userId` INT(11) NOT NULL, `username` VARCHAR(32) NOT NULL, `postDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function itemSave() {

        $query = "insert into itens(name, description, value, anouncePath, contact, userId, username)
        values(:name, :description, :value, :anouncePath, :contact, :userId, :username)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':description', $this->__get('description'));
        $stmt->bindValue(':value', $this->__get('value'));
        $stmt->bindValue(':anouncePath', $this->__get('anouncePath'));
        $stmt->bindValue(':contact', $this->__get('contact'));
        $stmt->bindValue(':userId', $this->__get('userId'));
        $stmt->bindValue(':username', $this->__get('username'));
        $stmt->execute();
    }

    public function itemEdit($item, $userId) {

        $query = "UPDATE itens SET name=:name, description=:description, value=:value, anouncePath=:anouncePath, contact=:contact WHERE id=:itemId AND userId=:userId";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':description', $this->__get('description'));
        $stmt->bindValue(':value', $this->__get('value'));
        $stmt->bindValue(':anouncePath', $this->__get('anouncePath'));
        $stmt->bindValue(':contact', $this->__get('contact'));
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':itemId', $item);
        $stmt->execute();

    }

    public function itemDelete($item, $userId) {
        $query = "delete from itens where id = :itemId and userId = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':itemId', $item);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

    }

    public function itemSearch($item) {

        $query = "
                select 
                    t.id, 
                    t.name,
                    t.description,
                    t.value,
                    t.anouncePath,
                    t.contact,
                    t.userId,
                    t.username,
                    DATE_FORMAT(t.postDate, '%d/%m/%Y %H:%i') as postDate
                from 
                    itens as t
                where 
                    t.name LIKE :itemName
            ";
    
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':itemName', $item);

            $stmt->execute();

            return $stmt->fetchAll();
    }

    public function itemReturn($item, $userId) {

        $query = "
                select 
                    t.id, 
                    t.name,
                    t.description,
                    t.value,
                    t.anouncePath,
                    t.contact,
                    t.userId,
                    DATE_FORMAT(t.postDate, '%d/%m/%Y %H:%i') as postDate
                from 
                    itens as t
                where 
                    t.userId = :userId
                and
                    t.id = :itemId
            ";
    
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':userId', $userId);
            $stmt->bindValue(':itemId', $item);
            $stmt->execute();

            return $stmt->fetch();
    }

    public function userItensByDate() {

        // $query = 'select * from itens where userId = currentUser
        // values(:currentUser)'

            $query = "
                select 
                    t.id, 
                    t.name,
                    t.description,
                    t.value,
                    t.anouncePath,
                    t.userId,
                    DATE_FORMAT(t.postDate, '%d/%m/%Y %H:%i') as postDate
                from 
                    itens as t
                where 
                    t.userId = :userId
                order by
                    t.postDate desc
            ";
    
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':userId', $this->__get('userId'));
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        
    }

    public function timelineItensByDate() {

        // $query = 'select * from itens where userId = currentUser
        // values(:currentUser)'

            $query = "
                select 
                    t.id, 
                    t.name,
                    t.description,
                    t.value,
                    t.anouncePath,
                    t.contact,
                    t.userId,
                    t.username,
                    DATE_FORMAT(t.postDate, '%d/%m/%Y %H:%i') as postDate
                from 
                    itens as t
                order by
                    t.postDate desc
            ";
    
            $stmt = $this->db->prepare($query);
            $stmt->execute();
    
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        
    }
}