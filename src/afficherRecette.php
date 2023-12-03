<!-- afficherRecette.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Détails de la recette</h1>

    <?php
    include_once 'config.php';

    $db = new Database();
    $conn = $db->getConnection();

    // Récupérez l'ID de la recette depuis les paramètres de l'URL
    $recette_id = $_GET['recette_id'];

    // Sélectionnez les détails de la recette
    $query = "SELECT recettes.nom AS recette_nom, categories.nom AS categorie_nom, recettes.etapes_recette, recettes.temps_preparation,
                ingredients.nom AS ingredient_nom, recette_ingredient.quantite
              FROM recettes
              INNER JOIN categories ON recettes.id_categorie = categories.id
              LEFT JOIN recette_ingredient ON recettes.id = recette_ingredient.recette_id
              LEFT JOIN ingredients ON recette_ingredient.ingredient_id = ingredients.id
              WHERE recettes.id = :recette_id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':recette_id', $recette_id);
    $stmt->execute();
    
    $recetteDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($recetteDetails) {
        $nomRecette = $recetteDetails[0]["recette_nom"];
        $categorieNom = $recetteDetails[0]["categorie_nom"];
        $etapesRecette = $recetteDetails[0]["etapes_recette"];
        $tempsPreparation = $recetteDetails[0]["temps_preparation"];
    
        // Affichage des détails de la recette
        echo "<h2>$nomRecette</h2>";
        echo "<p>Catégorie : $categorieNom</p>";
        echo "<p>Temps de préparation : $tempsPreparation minutes</p>";
        echo "<p>Étapes de la recette :</p>";
        echo "<ul>";
        $etapes = explode('.', $etapesRecette);
        foreach ($etapes as $etape) {
            $etape = trim($etape);
            if (!empty($etape)) {
                echo "<li>$etape</li>";
            }
        }
        echo "</ul>";
    
        // Affichage des ingrédients
        echo "<p>Ingrédients :</p>";
        echo "<ul>";
        foreach ($recetteDetails as $detail) {
            $ingredientNom = $detail["ingredient_nom"];
            $quantiteIngredient = $detail["quantite"];
            if ($ingredientNom && $quantiteIngredient) {
                echo "<li>$ingredientNom : $quantiteIngredient</li>";
            }
        }
        echo "</ul>";
        
        // Autres éléments de la page
    } else {
        echo "Aucune recette trouvée.";
    }
    ?>

</body>
</html>

