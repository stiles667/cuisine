<?php
class Ingredient
{
    private $db;
    public $id;
    public $nom;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllIngredients()
    {
        $query = "SELECT * FROM ingredients";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}