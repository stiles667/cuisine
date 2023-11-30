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
        <section class="recette">
            <h2>Nom de la recette 1</h2>
            <p>Description de la recette 1</p>
            <img src="chemin/vers/image1.jpg" alt="Image de la recette 1">
            <a href="#">Voir la recette</a>
        </section>

        <section class="recette">
            <h2>Nom de la recette 2</h2>
            <p>Description de la recette 2</p>
            <img src="chemin/vers/image2.jpg" alt="Image de la recette 2">
            <a href="#">Voir la recette</a>
        </section>
        <!-- Vous pouvez ajouter d'autres sections pour plus de recettes -->
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Recettes de cuisine</p>
    </footer>
</body>
</html>
