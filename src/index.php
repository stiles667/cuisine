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
        ?>

        <?php foreach ($recettesAvecDetails as $nomRecette => $details) : ?>
            <section class="recette">
                <h2><?= $nomRecette ?></h2>
                <p>Catégorie : <?= $details['categorie'] ?></p>
                <p>
                    Ingrédients :
                    <button onclick="showIngredients('<?= $nomRecette ?>')">Voir les ingrédients</button>
                </p>
                <p>...</p>
                <a href="#">Voir la recette</a>
            </section>
        <?php endforeach; ?>

        <div id="popup" class="popup">
            <h2 id="popup-title"></h2>
            <div id="popup-content"></div>
            <button onclick="hideIngredients()">Fermer</button>
        </div>
    </main>
   

    <footer>
        <p>&copy; <?= date("Y"); ?> Recettes de cuisine</p>
    </footer>

    <script>
        function showIngredients(nomRecette) {
            const ingredients = <?= json_encode($recettesAvecDetails) ?>;
            const popup = document.getElementById('popup');
            const title = document.getElementById('popup-title');
            const content = document.getElementById('popup-content');

            title.textContent = nomRecette;
            content.textContent = `Ingrédients : ${ingredients[nomRecette].ingredients.join(', ')}`;

            popup.style.display = 'block';
        }

        function hideIngredients() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
        }
    </script>
</body>
</html>
