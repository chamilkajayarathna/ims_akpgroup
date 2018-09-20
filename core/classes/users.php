<?php

class Users {

    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function firstTimeUserAdd() {
        $query = $this->db->prepare("SELECT COUNT(`id`) FROM `users`");
        try {
            $query->execute();
            $rows = $query->fetchColumn();
            if ($rows == 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function user_exists($username) {
        $query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= ?");
        $query->bindValue(1, $username);
        try {
            $query->execute();
            $rows = $query->fetchColumn();
            if ($rows == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function register($username, $password, $userLevel) {
        //$time 		= time();
        //$ip 		= $_SERVER['REMOTE_ADDR'];
        //$email_code = sha1($username + microtime());
        $password = sha1($password);
        $query = $this->db->prepare("INSERT INTO `users` (`username`, `password`, `userLevel`) VALUES (?, ?, ?) ");
        $query->bindValue(1, $username);
        $query->bindValue(2, $password);
        $query->bindValue(3, $userLevel);
        try {
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function login($username, $password) {
        $query = $this->db->prepare("SELECT `password`, `id` FROM `users` WHERE `username` = ?");
        $query->bindValue(1, $username);
        try {
            $query->execute();
            $data = $query->fetch();
            $stored_password = $data['password'];
            $id = $data['id'];
            if ($stored_password === sha1($password)) {
                return $id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function userdata($id) {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `id`= ?");
        $query->bindValue(1, $id);
        try {
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_users() {
        $query = $this->db->prepare("SELECT * FROM `users`");
        try {
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $query->fetchAll();
    }

}
