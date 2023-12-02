<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de la recherche</title>
    <link rel="stylesheet" href="index.css">
</head>
<header>
    <h1>Bienvenue dans notre collection de recettes</h1>
    <div class="header-right">
        <form action="recherche.php" method="get">
            <label for="search">Rechercher une recette : </label>
            <input type="text" id="search" name="search">
            <input type="submit" value="Rechercher">
        </form>
        <div class="button-wrapper">
            <a href="ajout.php">
                <button>Ajouter une recette</button>
            </a>
        </div>
    </div>
</header>
<body>
    <?php
    // recherche.php

    if (isset($_GET['search'])) {
        $servername = "localhost";
        $username = "root";
        $password = "1Aqzsedrf!";
        $dbname = "cuisine";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }
        $searchTerm = $conn->real_escape_string($_GET['search']);


        $query = "SELECT recettes.id AS recette_id, recettes.nom AS recette_nom, categories.nom AS categorie_nom
                  FROM recettes
                  INNER JOIN categories ON recettes.id_categorie = categories.id
                  WHERE recettes.nom LIKE '%$searchTerm%' OR categories.nom LIKE '%$searchTerm%'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $recetteId = $row["recette_id"];
                $nomRecette = $row["recette_nom"];
                $categorieNom = $row["categorie_nom"];
        ?>
                <section class="recette">
                    <div class="content">
                        <h2><?= $nomRecette ?></h2>
                        <p>Catégorie : <?= $categorieNom ?></p>
                        <p>
                            <a href="afficherRecette.php?recette_id=<?= $recetteId ?>">Voir la recette</a>
                        </p>
                        <p>
                            <a href="modif.php?id=<?= $recetteId ?>">Modifier la recette</a>
                        </p>
                        <form method="post" action="index.php">
                            <input type="hidden" name="delete_id" value="<?= $recetteId ?>">
                            <button type="submit" name="delete_recette">Supprimer</button>
                        </form>
                    </div>
                </section>
                
        <?php
        ob_start();
            }
        } else {
            echo "Aucune recette trouvée.";
        }
    
        require_once "config.php";
    require_once "Recette.php";
    
    // Check if the form was submitted for recipe deletion
    if (isset($_POST['delete_recette'])) {
        $recette_id = $_POST['delete_id'];
    
        $database = new Database();
        $db = $database->getConnection();
        $recette = new Recette($db);
    
        $result = $recette->deleteRecettes($recette_id);
    
        if ($result) {
            // Redirect after successful deletion
            header("Location: index.php");
            exit();
        } else {
            echo "Une erreur s'est produite lors de la suppression de la recette.";
        }
    }
    
        $conn->close();
        ob_end_flush();
    } else {
        echo "Aucun terme de recherche spécifié.";
    }
    ?>
</body>
</html>
