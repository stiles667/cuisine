<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recettes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Liste des recettes</h1>

    <?php
    include_once 'config.php';

    $db = new Database();
    $conn = $db->getConnection();

    // Sélectionnez toutes les recettes avec leurs détails
    $query = "SELECT recettes.id AS recette_id, recettes.nom AS recette_nom, categories.nom AS categorie_nom, recettes.etapes_recette, recettes.temps_preparation
              FROM recettes
              INNER JOIN categories ON recettes.id_categorie = categories.id";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($recettes) {
        // Parcours de toutes les recettes
        foreach ($recettes as $recette) {
            $recette_id = $recette["recette_id"];
            $nomRecette = $recette["recette_nom"];
            $categorieNom = $recette["categorie_nom"];
            $etapesRecette = $recette["etapes_recette"];
            // Fetch temps_preparation
            $tempsPreparation = $recette["temps_preparation"];

            // Sélectionnez les ingrédients pour chaque recette
            $queryIngredients = "SELECT ingredients.nom AS ingredient_nom
                                FROM ingredients
                                WHERE ingredients.recette_id = :recette_id";

            $stmtIngredients = $conn->prepare($queryIngredients);
            $stmtIngredients->bindParam(':recette_id', $recette_id);
            $stmtIngredients->execute();

            $ingredients = $stmtIngredients->fetchAll(PDO::FETCH_COLUMN);

            ?>
            <section class="recette">
                <div class="content">
                    <h2><?= $nomRecette ?></h2>
                    <p>Catégorie : <?= $categorieNom ?></p>
                    <p>Ingrédients : <?= implode(", ", $ingredients) ?></p>
                    <p>Temps de préparation : <?= $tempsPreparation ?> minutes</p> <!-- Display temps_preparation -->
                    <p>Étapes de la recette :</p>
                    <ul>
                        <?php
                        $etapes = explode('.', $etapesRecette);
                        foreach ($etapes as $etape) {
                            $etape = trim($etape);
                            if (!empty($etape)) {
                                echo "<li>$etape</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </section>
            <?php
        }
    } else {
        echo "Aucune recette trouvée.";
    }
    ?>

</body>
</html>
