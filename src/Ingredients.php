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

    public function ajouterIngredient($nom, $recette_id)
    {
        $query = "INSERT INTO ingredients (nom, recette_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);

        $nom = htmlspecialchars(strip_tags($nom));
        $recette_id = htmlspecialchars(strip_tags($recette_id));

        $stmt->execute([$nom, $recette_id]);
    }

    public function ajouterRecetteIngredient($recette_id, $ingredient_id, $quantite)
    {
        $query = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $stmt->execute([$recette_id, $ingredient_id, $quantite]);
 
    }

    
}

?>
