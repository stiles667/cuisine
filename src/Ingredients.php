<?php
class Ingredients
{
    private $db;
    public $id;
    public $nom;
    public $quantite;
    public $recette_id;

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
    public function ajouterIngredient($nom, $quantite, $recette_id)
    {
        $query = "INSERT INTO ingredients (nom, quantite, recette_id) VALUES (:nom, :quantite, :recette_id)";
        $stmt = $this->db->getConnection()->prepare($query);

        $nom = htmlspecialchars(strip_tags($nom));
        $quantite = htmlspecialchars(strip_tags($quantite));

        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":quantite", $quantite);
        $stmt->bindParam(":recette_id", $recette_id);

        $stmt->execute();
    }
}