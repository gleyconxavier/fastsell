<?php

namespace App;

class Connection {

    static function getDb() {
        try {

            // $conn = new \PDO('mysql:host=localhost;dbname=fastsell', 'root', '');
            $conn = new \PDO(
				"mysql:host=localhost;dbname=fastsell;charset=utf8",
				"root",
				"" 
			);
            return $conn;

         } catch (PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }

}