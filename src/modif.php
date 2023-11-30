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

        // Effectuez la modification de la recette
        $result = $recipe->editRecettes();

        // Effectuez la modification des ingrédients
        $ingredients = $_POST['ingredients'];
        foreach ($ingredients as $ingredient) {
            $recipe->id_ingredient = $ingredient['id'];
            $recipe->nom = $ingredient['nom'];
            $recipe->quantite = $ingredient['quantite'];
            $recipe->editIngredient();
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
            echo '<form action="modif.php" method="post">';
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
            foreach ($ingredients as $ingredient) {
                echo '<li>';
                echo 'Ingredient Name: <input type="text" name="ingredients[' . $ingredient['id'] . '][nom]" value="' . $ingredient['nom'] . '">';
                echo 'Quantity: <input type="text" name="ingredients[' . $ingredient['id'] . '][quantite]" value="' . $ingredient['quantite'] . '">';
                echo '<input type="hidden" name="ingredients[' . $ingredient['id'] . '][id]" value="' . $ingredient['id'] . '">';
                echo '</li>';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
</head>
<body>
<h1>Choisissez une recette à modifier :</h1>


<h2>Edit Recipe</h2>

<form action="modif.php?id=<?php echo $id; ?>" method="post">
    Recipe Name: <input type="text" name="nom" value="<?php echo $recipeData['nom']; ?>"><br>
    Image URL: <input type="text" name="image" value="<?php echo $recipeData['image']; ?>"><br>
    Difficulty: <input type="text" name="difficulte" value="<?php echo $recipeData['difficulte']; ?>"><br>
    Preparation Time (minutes): <input type="text" name="temps_preparation" value="<?php echo $recipeData['temps_preparation']; ?>"><br>
    Utensils: <input type="text" name="ustensiles" value="<?php echo $recipeData['ustensiles']; ?>"><br>
    Category: <input type="text" name="id_categorie" value="<?php echo $recipeData['id_categorie']; ?>"><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>

<?php } ?>
