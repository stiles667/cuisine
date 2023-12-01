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
    if (isset($_GET['recette_id'])) {
        include_once 'config.php';

        $db = new Database();
        $conn = $db->getConnection();

        $recette_id = $_GET['recette_id'];

        // Include temps_preparation in the query
        $query = "SELECT recettes.nom AS recette_nom, categories.nom AS categorie_nom, ingredients.nom AS ingredient_nom, recettes.etapes_recette, recettes.temps_preparation
                  FROM recettes
                  INNER JOIN categories ON recettes.id_categorie = categories.id
                  INNER JOIN ingredients ON ingredients.recette_id = recettes.id
                  WHERE recettes.id = :recette_id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->execute();

        $recetteDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($recetteDetails) {
            $nomRecette = $recetteDetails[0]["recette_nom"];
            $categorieNom = $recetteDetails[0]["categorie_nom"];
            $ingredients = array_column($recetteDetails, 'ingredient_nom');
            $etapesRecette = $recetteDetails[0]["etapes_recette"];
            // Fetch temps_preparation
            $tempsPreparation = $recetteDetails[0]["temps_preparation"];

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
                    
                    <button onclick="location.href='index.php'">Retour à l'accueil</button>
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