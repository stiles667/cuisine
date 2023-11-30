<?php
require './Ingredients.php';

class Recette
{
    private $db;
    public $id;
    public $nom;
    public $image;
    public $difficulte;
    public $temps_preparation;
    public $ustensiles;
    public $etapes_recette;
    public $id_categorie;
    public $id_ingredient;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterRecette()
    {
        $query = "INSERT INTO recettes
                  SET nom=?, 
                      image=?, 
                      difficulte=?, 
                      temps_preparation=?, 
                      ustensiles=?,
                      etapes_recette=?";

        $stmt = $this->db->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->difficulte = htmlspecialchars(strip_tags($this->difficulte));
        $this->temps_preparation = htmlspecialchars(strip_tags($this->temps_preparation));
        $this->ustensiles = htmlspecialchars(strip_tags($this->ustensiles));
        $this->etapes_recette = htmlspecialchars(strip_tags($this->etapes_recette));

        if ($stmt->execute([$this->nom, $this->image, $this->difficulte, $this->temps_preparation, $this->ustensiles, $this->etapes_recette])) {
            $recette_id = $this->db->lastInsertId();
            return $recette_id;
        }

        return false;
    }
}
?>
