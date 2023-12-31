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
    
}