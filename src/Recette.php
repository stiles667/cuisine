<?php
class Recette
{
    private $db;
    public $id;
    public $nom;
    public $image;
    public $difficulte;
    public $temps_preparation;
    public $ustensiles;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllRecettes()
    {
        $query = "SELECT * FROM recettes";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function addRecettes($data)
    {
        $query = "INSERT INTO recettes (nom, image, difficulte, temps_preparation, ustensiles) VALUES (:nom, :image, :difficulte, :temps_preparation, :ustensiles)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':difficulte', $data['difficulte']);
        $stmt->bindParam(':temps_preparation', $data['temps_preparation']);
        $stmt->bindParam(':ustensiles', $data['ustensiles']);
        $stmt->execute();
        return $stmt;
    }
    public function deleteRecettes($id)
    {
        $query = "DELETE FROM recettes WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
    
}