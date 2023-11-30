<?php
require './Recette.php';
require './config.php';

// Assurez-vous que votre instance de base de données est correctement définie ici
$your_db_instance = new Database();
$recipe = new Recette($your_db_instance);

// Vérifie si le paramètre 'id' est défini dans l'URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que les champs nécessaires sont présents dans le formulaire
    if (isset($_POST['nom'], $_POST['image'], $_POST['difficulte'], $_POST['temps_preparation'], $_POST['ustensiles'], $_POST['id_categorie'])) {
        // Remplissez les données de la recette
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
    // Si l'ID n'est pas fourni, redirigez l'utilisateur ou affichez un message d'erreur
    if (!$id) {
        echo 'L\'ID de la recette n\'est pas fourni.';
        exit;
    }

    // Obtenez les données de la recette
    $recipeData = $recipe->getRecipeById($id);

    // Vérifiez si la recette existe
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

<ul>
    <?php foreach ($recettes as $recette) : ?>
        <li>
            <a href="modifier_recette.php?id=<?php echo $recette['id']; ?>">
                <?php echo $recette['nom']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

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
