<?php
require './Recette.php';

require './config.php';

$database = new Database();
$db = $database->getConnection();
$recipe = new Recette($db);
$ingredientsManager = new Ingredients($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['image'], $_POST['difficulte'], $_POST['temps_preparation'], $_POST['ustensiles'], $_POST['id_categorie'])) {
        $recipe->id = $id;
        $recipe->nom = $_POST['nom'];
        $recipe->image = $_POST['image'];
        $recipe->difficulte = $_POST['difficulte'];
        $recipe->temps_preparation = $_POST['temps_preparation'];
        $recipe->ustensiles = $_POST['ustensiles'];
        $recipe->id_categorie = $_POST['id_categorie'];

        // Effectuez la modification de la recette
        $result = $recipe->editRecettes();

        // Effectuez la modification ou l'ajout des ingrédients
        $ingredients = $_POST['ingredients'];
        foreach ($ingredients as $ingredientId => $ingredientData) {
            $idIngredient = $ingredientData['id_ingredient'];
            $nomIngredient = isset($ingredientData['nom']) ? $ingredientData['nom'] : '';
            $quantiteIngredient = isset($ingredientData['quantite']) ? $ingredientData['quantite'] : '';

            // Modifiez la quantité dans la table recette_ingredient
            $ingredientsManager->editQuantiteIngredient($idRecetteIngredient, $idRecette, $idIngredient, $nouvelleQuantite);

        }

        if ($result) {
            echo 'La recette a été modifiée avec succès.';
        } else {
            echo 'Une erreur s\'est produite lors de la modification de la recette.';
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire.';
    }
} else {
    if (!$id) {
        echo 'L\'ID de la recette n\'est pas fourni.';
        exit;
    }

    // Si l'ID est défini dans l'URL, affichez le formulaire de modification
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $recipeData = $recipe->getRecipeById($id);
        $ingredients = $recipe->getIngredientsByRecipeId($id);

        if ($recipeData) {
            // Affichez le formulaire de modification
            echo '<h2>Edit Recipe</h2>';
            echo '<form action="modif.php?id=' . $id . '" method="post">';
            echo '<input type="hidden" name="id" value="' . $recipeData['id'] . '">';
            echo 'Recipe Name: <input type="text" name="nom" value="' . $recipeData['nom'] . '"><br>';
            echo 'Image URL: <input type="text" name="image" value="' . $recipeData['image'] . '"><br>';
            echo 'Difficulty: <input type="text" name="difficulte" value="' . $recipeData['difficulte'] . '"><br>';
            echo 'Preparation Time (minutes): <input type="text" name="temps_preparation" value="' . $recipeData['temps_preparation'] . '"><br>';
            echo 'Utensils: <input type="text" name="ustensiles" value="' . $recipeData['ustensiles'] . '"><br>';
            echo 'Category: <input type="text" name="id_categorie" value="' . $recipeData['id_categorie'] . '"><br>';

            // Affichez les ingrédients
            echo '<h2>Ingredients</h2>';
            foreach ($ingredients as $ingredient) {
                // Vérifier si la clé 'id_ingredient' existe avant de l'utiliser
                $idIngredient = isset($ingredient['id_ingredient']) ? $ingredient['id_ingredient'] : '';

                echo '<input type="hidden" name="ingredients[' . $idIngredient . '][id_ingredient]" value="' . $idIngredient . '">';
                echo 'Ingredient Name: <input type="text" name="ingredients[' . $idIngredient . '][nom]" value="' . $ingredient['nom'] . '">';
                echo 'Quantity: <input type="text" name="ingredients[' . $idIngredient . '][quantite]" value="' . $ingredient['quantite'] . '"><br>';
            }

            echo '<input type="submit" value="Submit">';
            echo '</form>';
        } else {
            echo 'La recette avec cet ID n\'existe pas.';
        }
    } else {
        echo 'L\'ID de la recette n\'est pas fourni.';
    }
}
?>
