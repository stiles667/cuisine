<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recettes de cuisine</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue dans notre collection de recettes</h1>
        <nav>
            <ul>
                <li><a href="#">Recettes Salées</a></li>
                <li><a href="#">Recettes Sucrées</a></li>
                <li><a href="#">Recettes Végétariennes</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="recette">
            <h2>Nom de la recette</h2>
            <p>Description de la recette</p>
            <img src="chemin/vers/image.jpg" alt="Image de la recette">
            <a href="#">Voir la recette</a>
        </section>
        <section class="recette">
            <h2>Nom de la recette</h2>
            <p>Description de la recette</p>
            <img src="chemin/vers/image.jpg" alt="Image de la recette">
            <a href="#">Voir la recette</a>
        </section>
        
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Recettes de cuisine</p>
    </footer>
</body>
</html>
