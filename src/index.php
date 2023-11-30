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
    </header>

    

    <main>
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "ilyass";
        $dbname = "cuisine";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }

        // Fonction pour récupérer les recettes avec leurs détails depuis la base de données
        function getRecettesWithDetails() {
            global $conn;

            $query = "SELECT recettes.nom AS recette_nom, categories.nom AS categorie_nom, ingredients.nom AS ingredient_nom
                      FROM recettes
                      INNER JOIN categories ON recettes.id_categorie = categories.id
                      INNER JOIN ingredients ON recettes.id_ingredient = ingredients.id";

            $result = $conn->query($query);

            $recettes = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recetteNom = $row["recette_nom"];
                    $categorieNom = $row["categorie_nom"];
                    $ingredientNom = $row["ingredient_nom"];

                    if (!isset($recettes[$recetteNom])) {
                        $recettes[$recetteNom] = array(
                            "categorie" => $categorieNom,
                            "ingredients" => array($ingredientNom)
                        );
                    } else {
                        $recettes[$recetteNom]["ingredients"][] = $ingredientNom;
                    }
                }
            }

            return $recettes;
        }

        // Récupérer les recettes avec leurs détails
        $recettesAvecDetails = getRecettesWithDetails();

        // Afficher les recettes avec leurs détails
        foreach ($recettesAvecDetails as $nomRecette => $details) {
            echo '<section class="recette">';
            echo '<h2>' . $nomRecette . '</h2>';
            echo '<p>Catégorie : ' . $details['categorie'] . '</p>';
            echo '<p>Ingrédients : ' . implode(", ", $details['ingredients']) . '</p>';
            echo '<a href="#">Voir la recette</a>';
            echo '</section>';
        }

        // Fermeture de la connexion à la base de données
        $conn->close();
        ?>
        <!-- Vous pouvez ajouter d'autres sections pour plus de recettes -->
    </main>
   

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Recettes de cuisine</p>
    </footer>
</body>
</html>
