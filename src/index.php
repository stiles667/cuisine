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
        $password = "1Aqzsedrf!"; 
        $dbname = "cuisine";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }

        // Fonction pour récupérer les recettes avec leurs détails depuis la base de données
        function getRecettesWithDetails() {
            global $conn;

            $query = "SELECT recettes.id AS recette_id, recettes.nom AS recette_nom, categories.nom AS categorie_nom, ingredients.nom AS ingredient_nom
            FROM recettes
            INNER JOIN categories ON recettes.id_categorie = categories.id
            INNER JOIN ingredients ON ingredients.recette_id = recettes.id";


            $result = $conn->query($query);

            $recettes = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recetteId = $row["recette_id"];
                    $recetteNom = $row["recette_nom"];
                    $categorieNom = $row["categorie_nom"];
                    $ingredientNom = $row["ingredient_nom"];
                
                    if (!isset($recettes[$recetteNom])) {
                        $recettes[$recetteNom] = array(
                            "id" => $recetteId,
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
            <button onclick="showIngredients('<?= $nomRecette ?>')">Voir les ingrédients</button>
        </p>
        <p>...</p>
        <?php if (isset($details['id'])) : ?>
            <a href="modif.php?id=<?= $details['id'] ?>">Modifier la recette</a>
        <?php else : ?>
            <p>Erreur : ID non défini pour cette recette.</p>
        <?php endif; ?>
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