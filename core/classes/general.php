<?php

class General {

    public function logged_in() {
        return(isset($_SESSION['id'])) ? true : false;
    }

    public function logged_in_protect() {
        if ($this->logged_in() === true) {
            header('Location: ../index.php');
            exit();
        }
    }

    public function logged_out_protect() {
        if ($this->logged_in() === false) {
            header('Location: ../index.php');
            exit();
        }
    }

    public function admin_logedIn() {
        if ($this->logged_in() === true) {
            echo "<a href='login/logout.php' class='button-link'>Logout</a>";
            //exit();		
        }
    }

    public function deny() {
        if ($this->logged_in() === false) {
            header('Location: '.WWWROOT.'application/login/deny.php');
            exit();
        }
    }

    public function level($logAuth) {
        if ($logAuth == 2) {
            header('Location: ' . WWWROOT . 'application/login/deny.php');
            exit();
        }
    }

    public function register() {
        if ($this->logged_in() === false) {
            header('Location: register.php');
            exit();
        }
    }

}
