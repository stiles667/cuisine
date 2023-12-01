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

   
    public function ajouterRecetteIngredient($recette_id, $ingredient_id, $quantite)
    {
        $query = "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $stmt->execute([$recette_id, $ingredient_id, $quantite]);
 
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
public function deleteIngredient($ingredientId)
    {
        $query = "DELETE FROM ingredients WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $ingredientId);
        $stmt->execute();
        return $stmt;
    }
    public function getIngredientById($ingredientId)
    {
        $query = "SELECT * FROM ingredients WHERE id = :ingredient_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ingredient_id', $ingredientId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function editIngredient($id, $nom)
{
    $checkQuery = "SELECT * FROM ingredients WHERE id = :id";
    $checkStmt = $this->db->prepare($checkQuery);
    $checkStmt->bindParam(':id', $id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        $updateQuery = "UPDATE ingredients SET nom = :nom WHERE id = :id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':id', $id);
        $updateStmt->bindParam(':nom', $nom);
        $updateStmt->execute();

        return $updateStmt;
    } else {
        echo "L'ingrédient avec l'ID $id n'existe pas.";
        return false;
    }
}
public function editQuantiteIngredient($recipeId, $ingredientId, $quantity) {
    $query = "UPDATE recette_ingredient 
              SET quantite = :quantity 
              WHERE recette_id = :recette_id AND ingredient_id = :ingredient_id";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':recette_id', $recipeId);
    $stmt->bindParam(':ingredient_id', $ingredientId);
    $stmt->execute();
}


}


?>
