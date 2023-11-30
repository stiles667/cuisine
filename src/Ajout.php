<?php

include_once './config.php';
include_once './Recette.php';
include_once './Ingredients.php';

$database = new Database();
$db = $database->getConnection();
$recette = new Recette($db);
$ingredientsManager = new Ingredients($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recette->nom = htmlspecialchars(strip_tags($_POST['nom_recette']));
    $recette->image = htmlspecialchars(strip_tags($_POST['image_recette']));
    $recette->difficulte = htmlspecialchars(strip_tags($_POST['difficulte_recette']));
    $recette->temps_preparation = htmlspecialchars(strip_tags($_POST['temps_preparation']));
    $recette->ustensiles = htmlspecialchars(strip_tags($_POST['ustensiles_recette']));
    $recette->etapes_recette = htmlspecialchars(strip_tags($_POST['etapes_recette']));

    $recette_id = $recette->ajouterRecette();


    if (isset($_POST['ingredient_nom']) && isset($_POST['ingredient_quantite'])) {
        $ingredient_noms = $_POST['ingredient_nom'];
        $ingredient_quantites = $_POST['ingredient_quantite'];

        foreach ($ingredient_noms as $key => $ingredient_nom) {
            $ingredient_quantite = $ingredient_quantites[$key];
            $ingredientsManager->ajouterIngredient($ingredient_nom, $ingredient_quantite, $recette_id);
        }
    }

    if ($recette_id) {
        echo "La recette a été ajoutée avec succès. Identifiant de la recette : $recette_id";
    } else {
        echo "Erreur lors de l'ajout de la recette.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une nouvelle recette</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <h2>Créer une nouvelle recette</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nom_recette">Nom de la recette:</label>
        <input type="text" name="nom_recette" required><br>

        <label for="image_recette">Image de la recette (URL):</label>
        <input type="text" name="image_recette"><br>

        <label for="difficulte_recette">Difficulté:</label>
        <input type="text" name="difficulte_recette"><br>

        <label for="temps_preparation">Temps de préparation (en minutes):</label>
        <input type="number" name="temps_preparation" min="0" required><br>

        <label for="ustensiles_recette">Ustensiles:</label>
        <input type="text" name="ustensiles_recette"><br>

        <label for="etapes_recette">Étapes de la recette:</label>
        <textarea name="etapes_recette" rows="4" cols="50" required></textarea><br>

        <h3>Ingrédients:</h3>
        <div id="ingredients-container">
            <div class="ingredient">
                <label for="ingredient_nom[]">Nom de l'ingrédient:</label>
                <input type="text" name="ingredient_nom[]" required>

                <label for="ingredient_quantite[]">Quantité:</label>
                <input type="number" name="ingredient_quantite[]" min="0" required>
            </div>
        </div>
        
        <button type="button" id="ajouter-ingredient">Ajouter un ingrédient</button>

        <input type="submit" value="Ajouter la recette">
    </form>

    <script>
        $(document).ready(function() {
            $("#ajouter-ingredient").click(function() {
                var newIngredient = $("#ingredients-container .ingredient:first").clone();
                newIngredient.find("input").val("");
                $("#ingredients-container").append(newIngredient);
            });
        });
    </script>
</body>
</html>
