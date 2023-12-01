    <?php
    require './Ingredients.php';

class Recette
{
    private $db;
    public $id;
    public $nom;
    public $image;
    public $difficulte;
    public $quantite;
    public $temps_preparation;
    public $ustensiles;
    public $etapes_recette;
    private $ingredients;
    public $id_categorie;
    public $id_ingredient;
    public function __construct($db)
    {
        $this->db = $db;
        $this->ingredients = new Ingredients($db);
    }

    public function getAllRecettes()
    {
        $query = "SELECT * FROM recettes";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function getCategories() {
        $query = "SELECT id, nom FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function ajouterRecette()
{
    $queryRecette = "INSERT INTO recettes 
                     (nom, image, difficulte, temps_preparation, ustensiles, etapes_recette, id_categorie)
                     VALUES (:nom_recette, :image_recette, :difficulte_recette, :temps_preparation, :ustensiles_recette, :etapes_recette, :id_categorie)";

    $stmtRecette = $this->db->prepare($queryRecette);

    $this->nom = htmlspecialchars(strip_tags($this->nom));
    $this->image = htmlspecialchars(strip_tags($this->image));
    $this->difficulte = htmlspecialchars(strip_tags($this->difficulte));
    $this->temps_preparation = htmlspecialchars(strip_tags($this->temps_preparation));
    $this->ustensiles = htmlspecialchars(strip_tags($this->ustensiles));
    $this->etapes_recette = htmlspecialchars(strip_tags($this->etapes_recette));
    $this->id_categorie = htmlspecialchars(strip_tags($this->id_categorie));

    $stmtRecette->bindParam(":nom_recette", $this->nom);
    $stmtRecette->bindParam(":image_recette", $this->image);
    $stmtRecette->bindParam(":difficulte_recette", $this->difficulte);
    $stmtRecette->bindParam(":temps_preparation", $this->temps_preparation);
    $stmtRecette->bindParam(":ustensiles_recette", $this->ustensiles);
    $stmtRecette->bindParam(":etapes_recette", $this->etapes_recette);
    $stmtRecette->bindParam(":id_categorie", $this->id_categorie); 

    if ($stmtRecette->execute()) {
        $recetteId = $this->db->lastInsertId();

        if (!empty($_POST['ingredient_nom'])) {
            $ingredient_noms = $_POST['ingredient_nom'];
            $ingredient_quantites = $_POST['ingredient_quantite'];

            foreach ($ingredient_noms as $key => $ingredient_nom) {
                $ingredient_quantite = $ingredient_quantites[$key];
                $this->ajouterIngredient($ingredient_nom, $ingredient_quantite, $recetteId);
            }
        }

        return $recetteId;
    }

    return false;
}

public function ajouterIngredient($nom, $quantite, $recetteId)
{
    $queryCheckIngredient = "SELECT id FROM ingredients WHERE nom = :nom";
    $stmtCheckIngredient = $this->db->prepare($queryCheckIngredient);
    $stmtCheckIngredient->bindParam(":nom", $nom);
    $stmtCheckIngredient->execute();

    if ($stmtCheckIngredient->rowCount() > 0) {
        $row = $stmtCheckIngredient->fetch(PDO::FETCH_ASSOC);
        $ingredientId = $row['id'];
    } else {
        $queryIngredient = "INSERT INTO ingredients (nom) VALUES (:nom)";
        $stmtIngredient = $this->db->prepare($queryIngredient);
        $stmtIngredient->bindParam(":nom", $nom);
        $stmtIngredient->execute();

        $ingredientId = $this->db->lastInsertId();
    }


    $queryRecetteIngredient = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES (:recette_id, :ingredient_id, :quantite)";
    $stmtRecetteIngredient = $this->db->prepare($queryRecetteIngredient);

    $stmtRecetteIngredient->bindParam(":recette_id", $recetteId);
    $stmtRecetteIngredient->bindParam(":ingredient_id", $ingredientId);
    $stmtRecetteIngredient->bindParam(":quantite", $quantite);

    $stmtRecetteIngredient->execute();
}


public function deleteRecettes($id) {
    // First, handle associated records in recette_ingredient table
    $queryDeleteRecetteIngredient = "DELETE FROM recette_ingredient WHERE recette_id = :id";
    $stmtDeleteRecetteIngredient = $this->db->prepare($queryDeleteRecetteIngredient);
    $stmtDeleteRecetteIngredient->bindParam(':id', $id);
    $stmtDeleteRecetteIngredient->execute();

    // Then, delete the recipe from the recettes table
    $queryDeleteRecette = "DELETE FROM recettes WHERE id = :id";
    $stmtDeleteRecette = $this->db->prepare($queryDeleteRecette);
    $stmtDeleteRecette->bindParam(':id', $id);
    $stmtDeleteRecette->execute();

    return $stmtDeleteRecette; // Or handle success/failure accordingly
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
            // Vérifier d'abord si l'ingrédient existe
            $checkQuery = "SELECT * FROM recette_ingredient WHERE id = :id";
            $checkStmt = $this->db->getConnection()->prepare($checkQuery);
            $checkStmt->bindParam(':id', $this->id_ingredient);
            $checkStmt->execute();
        
            if ($checkStmt->rowCount() > 0) {
                // L'ingrédient existe, effectuer la mise à jour
                $updateQuery = "UPDATE recette_ingredient SET quantite = :quantite WHERE id = :id";
                $updateStmt = $this->db->getConnection()->prepare($updateQuery);
                $updateStmt->bindParam(':id', $this->id_ingredient);
                $updateStmt->bindParam(':quantite', $this->quantite);
                $updateStmt->execute();
        
                return $updateStmt;
            } else {
                // L'ingrédient n'existe pas
                echo "L'ingrédient avec l'ID " . $this->id_ingredient . " n'existe pas.";
                return false;
            }
        }
        

        public function getIngredientsByRecipeId($recipeId)
        {
            $query = "SELECT * FROM ingredients WHERE recette_id = :recipe_id";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindParam(':recipe_id', $recipeId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
