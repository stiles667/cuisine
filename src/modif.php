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

        // Effectuez la modification
        $result = $recipe->editRecettes();

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


    $recipeData = $recipe->getRecipeById($id);

   
    if (!$recipeData) {
        echo 'La recette avec cet ID n\'existe pas.';
        exit;
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
