<?php

class Users {

    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function firstTimeUserAdd() {
        $query = $this->db->prepare("SELECT COUNT(`ID`) FROM `user`");
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
        $query = $this->db->prepare("SELECT COUNT(`ID`) FROM `user` WHERE `USERNAME`= ?");
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
        $query = $this->db->prepare("INSERT INTO `user` (`USERNAME`, `PASSWORD`, `USER_LEVEL`) VALUES (?, ?, ?) ");
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
        $query = $this->db->prepare("SELECT * FROM `user` WHERE `USERNAME` = ? and `PASSWORD`=?");
        $query->bindValue(1, $username);
        $pass = sha1($password);
        $query->bindValue(2, sha1($password));
        try {
            $query->execute();
            $data = $query->fetch();
            if($data){
                return $data['ID'];
            }
            else {
                return false;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function userdata($id) {
        $query = $this->db->prepare("SELECT * FROM `user` WHERE `ID`= ?");
        $query->bindValue(1, $id);
        try {
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_users() {
        $query = $this->db->prepare("SELECT * FROM `user`");
        try {
            $query->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $query->fetchAll();
    }

}
