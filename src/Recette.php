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
    public $etapes_recette;
    public $id_categorie;
    public $id_ingredient;

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
    public function ajouterRecette()
    {
        $query = "INSERT INTO recettes
                  SET nom_recette=:nom_recette, 
                      image_recette=:image_recette, 
                      difficulte_recette=:difficulte_recette, 
                      temps_preparation=:temps_preparation, 
                      ustensiles_recette=:ustensiles_recette,
                      etapes_recette=:etapes_recette,
                      id_categorie=:id_categorie,
                      id_ingredient=:id_ingredient";

        $stmt = $this->db->getConnection()->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->difficulte = htmlspecialchars(strip_tags($this->difficulte));
        $this->temps_preparation = htmlspecialchars(strip_tags($this->temps_preparation));
        $this->ustensiles = htmlspecialchars(strip_tags($this->ustensiles));
        $this->etapes_recette = htmlspecialchars(strip_tags($this->etapes_recette));
        $this->id_categorie = htmlspecialchars(strip_tags($this->id_categorie));
        $this->id_ingredient = htmlspecialchars(strip_tags($this->id_ingredient));

        $stmt->bindParam(":nom_recette", $this->nom);
        $stmt->bindParam(":image_recette", $this->image);
        $stmt->bindParam(":difficulte_recette", $this->difficulte);
        $stmt->bindParam(":temps_preparation", $this->temps_preparation);
        $stmt->bindParam(":ustensiles_recette", $this->ustensiles);
        $stmt->bindParam(":etapes_recette", $this->etapes_recette);
        $stmt->bindParam(":id_categorie", $this->id_categorie);
        $stmt->bindParam(":id_ingredient", $this->id_ingredient);
        $lastInsertId = $this->db->getConnection()->lastInsertId();

        return $lastInsertId;

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}