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
    <a href="ajout.php">
        <button>Ajouter une recette</button>
    </a>
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
        $query = "SELECT recettes.id AS recette_id, recettes.nom AS recette_nom, categories.nom AS categorie_nom
                  FROM recettes
                  INNER JOIN categories ON recettes.id_categorie = categories.id";
                  

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
                    </div>
                </section>
        <?php
            }
        } else {
            echo "Aucune recette trouvée.";
        }

        $conn->close();
        ?>
    </main>

    <footer>
        <p>&copy; <?= date("Y"); ?> Recettes de cuisine</p>
    </footer>
</body>
</html>
