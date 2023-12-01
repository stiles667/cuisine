<?php
require './Recette.php';
require './config.php';

$your_db_instance = new Database();
$recipe = new Recette($your_db_instance);

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

        $result = $recipe->editRecettes();

        if (isset($_POST['id'], $_POST['recette_id'], $_POST['ingredient_id'], $_POST['quantite'])) {
            $id = $_POST['id'];
            $recette_id = $_POST['recette_id'];
            $ingredient_id = $_POST['ingredient_id'];
            $quantite = $_POST['quantite'];
            $stmt->execute();
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
            echo '<ul>';
            // var_dump($ingredients);

                foreach ($ingredients as $ingredient) {
                    // Check if the key "id" exists before accessing it
                    $ingredientId = isset($ingredient['id']) ? $ingredient['id'] : null;
                    echo 'Ingredient ID: ' . $ingredientId . '<br>';

                    // Check if the key "recette_id" exists before accessing it
                    $recetteId = isset($ingredient['recette_id']) ? $ingredient['recette_id'] : null;
                    echo 'Recipe ID: ' . $recetteId . '<br>';

                    // Check if the key "ingredient_id" exists before accessing it
                    $ingredientId = isset($ingredient['ingredient_id']) ? $ingredient['ingredient_id'] : null;
                    echo 'Ingredient ID: ' . $ingredientId . '<br>';

                    // Check if the key "quantite" exists before accessing it
                    $quantity = isset($ingredient['quantite']) ? $ingredient['quantite'] : null;
                    echo 'Quantity: ' . $quantity . '<br>';
                }
            echo '</ul>';

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
