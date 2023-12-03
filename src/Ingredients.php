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
    public function getDb() {
        return $this->db;
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
    // Supprimez d'abord les références dans la table recette_ingredient
    $queryDeleteReferences = "DELETE FROM recette_ingredient WHERE ingredient_id = :id";
    $stmtDeleteReferences = $this->db->prepare($queryDeleteReferences);
    $stmtDeleteReferences->bindParam(':id', $ingredientId);
    $stmtDeleteReferences->execute();

    // Ensuite, supprimez l'ingrédient lui-même
    $queryDeleteIngredient = "DELETE FROM ingredients WHERE id = :id";
    $stmtDeleteIngredient = $this->db->prepare($queryDeleteIngredient);
    $stmtDeleteIngredient->bindParam(':id', $ingredientId);
    $stmtDeleteIngredient->execute();

    return $stmtDeleteIngredient;
}
    public function getIngredientById($ingredientId)
    {
        $query = "SELECT * FROM ingredients WHERE id = :ingredient_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ingredient_id', $ingredientId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function editQuantiteIngredient($idRecetteIngredient, $idRecette, $idIngredient, $nouvelleQuantite)
{
    if (!is_numeric($nouvelleQuantite) || $nouvelleQuantite == '') {
        echo "Quantite must be a valid integer";
        return;
    }

    // Vérifier d'abord si l'ingrédient existe
    $checkQuery = "SELECT * FROM recette_ingredient WHERE id = :id AND recette_id = :recette_id AND ingredient_id = :ingredient_id";
    $checkStmt = $this->db->prepare($checkQuery);
    $checkStmt->bindParam(':id', $idRecetteIngredient);
    $checkStmt->bindParam(':recette_id', $idRecette);
    $checkStmt->bindParam(':ingredient_id', $idIngredient);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // L'ingrédient existe, effectuer la mise à jour
        $updateQuery = "UPDATE recette_ingredient SET quantite = :quantite WHERE id = :id AND recette_id = :recette_id AND ingredient_id = :ingredient_id";
        $updateStmt = $this->db->prepare($updateQuery);
        $updateStmt->bindParam(':id', $idRecetteIngredient);
        $updateStmt->bindParam(':recette_id', $idRecette);
        $updateStmt->bindParam(':ingredient_id', $idIngredient);
        $updateStmt->bindParam(':quantite', $nouvelleQuantite);
        $updateStmt->execute();

        return $updateStmt;
    } else {
        // L'ingrédient n'existe pas, affichez un message d'erreur
        echo "L'ingrédient avec l'ID $idIngredient n'existe pas.";
    }
}


}


?>
