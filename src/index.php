<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recettes de cuisine</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
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

<main>
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "Khaled";
    $dbname = "cuisine";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Récupérer les recettes avec leurs détails
    $query = "SELECT recettes.id AS recette_id, recettes.nom AS recette_nom, categories.nom AS categorie_nom, recettes.image AS image_url
    FROM recettes
    INNER JOIN categories ON recettes.id_categorie = categories.id";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $recetteId = $row["recette_id"];
            $nomRecette = $row["recette_nom"];
            $categorieNom = $row["categorie_nom"];
            $imageUrl = $row["image_url"];

            if (isset($imageUrl)) {
                // Affiche la section de recette avec l'image en background
                echo '<section class="recette" style="background-image: url(\'' . $imageUrl . '\');">';
            } else {
                // Affiche la section de recette sans image en background
                echo '<section class="recette">';
            }
    ?>
            
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
    ?>
</main>

<footer>
    <p>&copy; <?= date("Y"); ?> Recettes de cuisine</p>
</footer>
</body>
</html>