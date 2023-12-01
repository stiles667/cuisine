

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Détails de la recette</h1>

    <?php
    // Vérification si l'identifiant de la recette est présent dans l'URL
    if (isset($_GET['recette_id'])) {
        // Inclusion du fichier de configuration de la base de données
        include_once 'config.php';

        // Instanciation de la classe Database
        $db = new Database();
        $conn = $db->getConnection();

        // Récupération de l'identifiant de la recette depuis l'URL
        $recette_id = $_GET['recette_id'];

        // Requête pour obtenir les détails de la recette et ses ingrédients
        $query = "SELECT recettes.nom AS recette_nom, categories.nom AS categorie_nom, ingredients.nom AS ingredient_nom
                  FROM recettes
                  INNER JOIN categories ON recettes.id_categorie = categories.id
                  INNER JOIN ingredients ON ingredients.recette_id = recettes.id
                  WHERE recettes.id = :recette_id";

        // Préparation de la requête
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->execute();

        $recetteDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($recetteDetails) {
            $nomRecette = $recetteDetails[0]["recette_nom"];
            $categorieNom = $recetteDetails[0]["categorie_nom"];
            $ingredients = array_column($recetteDetails, 'ingredient_nom');
        
            ?>
            <section class="recette">
                <div class="content">
                    <h2><?= $nomRecette ?></h2>
                    <p>Catégorie : <?= $categorieNom ?></p>
                    <p>Ingrédients : <?= implode(", ", $ingredients) ?></p>
                </div>
            </section>
            <?php
        } else {
            echo "Aucune recette trouvée.";
        }
    } else {
        echo "Identifiant de la recette non spécifié.";
    }
    ?>

</body>
</html>
