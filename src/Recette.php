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
}