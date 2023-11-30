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
    public $quantite;
    public $id_categorie;
    public $id_ingredient;
    public $quantite;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterRecette()
    {
        $query = "SELECT * FROM recettes";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addRecettes($data)
    {
        $query = "INSERT INTO recettes (nom, image, difficulte, temps_preparation, ustensiles, id_categorie) 
                  VALUES (:nom, :image, :difficulte, :temps_preparation, :ustensiles, :id_categorie)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':difficulte', $data['difficulte']);
        $stmt->bindParam(':temps_preparation', $data['temps_preparation']);
        $stmt->bindParam(':ustensiles', $data['ustensiles']);
        $stmt->bindParam(':id_categorie', $data['id_categorie']); 
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

    public function editRecettes()
    {
        $query = "UPDATE recettes 
                  SET nom = :nom, image = :image, difficulte = :difficulte, 
                  temps_preparation = :temps_preparation, ustensiles = :ustensiles, id_categorie = :id_categorie 
                  WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':difficulte', $this->difficulte);
        $stmt->bindParam(':temps_preparation', $this->temps_preparation);
        $stmt->bindParam(':ustensiles', $this->ustensiles);
        $stmt->bindParam(':id_categorie', $this->id_categorie);
        $stmt->execute();
        return $stmt;
    }

    public function addIngredient($data)
    {
        $query = "INSERT INTO ingredients (nom, quantite, recette_id) 
                  VALUES (:nom, :quantite, :recette_id)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':quantite', $data['quantite']);
        $stmt->bindParam(':recette_id', $data['recette_id']);
        $stmt->execute();
        return $stmt;
    }

    public function deleteIngredient($ingredientId)
    {
        $query = "DELETE FROM ingredients WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $ingredientId);
        $stmt->execute();
        return $stmt;
    }
    public function getRecipeById($id)
    {
        $query = "SELECT * FROM recettes WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editIngredient()
    {
        $query = "UPDATE ingredients 
                  SET nom = :nom, quantite = :quantite 
                  WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $this->id_ingredient);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':quantite', $this->quantite);
        $stmt->execute();
        return $stmt;
    }
}
