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
    $query = "SELECT recettes.nom AS recette_nom, categories.nom AS categorie_nom, recettes.etapes_recette, recettes.temps_preparation
              FROM recettes
              INNER JOIN categories ON recettes.id_categorie = categories.id
              WHERE recettes.id = :recette_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':recette_id', $recette_id);
    $stmt->execute();

    $recetteDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recetteDetails) {
        $nomRecette = $recetteDetails["recette_nom"];
        $categorieNom = $recetteDetails["categorie_nom"];
        $etapesRecette = $recetteDetails["etapes_recette"];
        $tempsPreparation = $recetteDetails["temps_preparation"];

        ?>
        <section class="recette">
            <div class="content">
                <h2><?= $nomRecette ?></h2>
                <p>Catégorie : <?= $categorieNom ?></p>
                <p>Temps de préparation : <?= $tempsPreparation ?> minutes</p>
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
    ?>

</body>
</html>

