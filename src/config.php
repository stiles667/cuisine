<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "Khaled";
    private $dbname = "cuisine";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
            die();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
