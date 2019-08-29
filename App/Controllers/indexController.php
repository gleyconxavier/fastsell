<?php

namespace App\Controllers;

class indexController {

    public function getUrl() {
        print_r($_SERVER['REQUEST_URI']);
    }

}

?>