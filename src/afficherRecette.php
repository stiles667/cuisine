
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la recette</title>
    <link rel="stylesheet" href="afficherRecette.css">
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
   
       // Affichage des détails de la recette dans un tableau
       echo "<table>";
       echo "<tr><th colspan='2'>$nomRecette</th></tr>";
       echo "<tr><td>Catégorie</td><td>$categorieNom</td></tr>";
       echo "<tr><td>Temps de préparation</td><td>$tempsPreparation minutes</td></tr>";
       echo "<tr><td colspan='2'><strong>Étapes de la recette</strong></td></tr>";
       echo "<tr><td colspan='2'><ul>";
       $etapes = explode('.', $etapesRecette);
       foreach ($etapes as $etape) {
           $etape = trim($etape);
           if (!empty($etape)) {
               echo "<li>$etape</li>";
           }
       }
       echo "</ul></td></tr>";
       echo "<tr><td colspan='2'><strong>Ingrédients</strong></td></tr>";
       foreach ($recetteDetails as $detail) {
           $ingredientNom = $detail["ingredient_nom"];
           $quantiteIngredient = $detail["quantite"];
           if ($ingredientNom && $quantiteIngredient) {
               echo "<tr><td>$ingredientNom</td><td>$quantiteIngredient</td></tr>";
           }
       }
       echo "</table>";
       
       // Autres éléments de la page
   } else {
       echo "Aucune recette trouvée.";
   }
   ?>

</body>
</html>

