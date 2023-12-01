<?php
class Categorie
{
    private $db;

    public $id;
    public $nom;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function ajouterCategorie($nom)
{
    $query = "INSERT INTO categories (nom) VALUES (:nom)";
    $stmt = $this->db->prepare($query);

    $stmt->bindParam(":nom", $nom);

    if ($stmt->execute()) {
        return true;
    }

    return false;
}
}