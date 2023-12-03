<?php
require_once 'src/Recette.php';

use PHPUnit\Framework\TestCase;

class RecetteTest extends TestCase
{
    private $recipeManager;
    private $ingredientsManager;
    private $db;

    public function setUp(): void
    {
        // Configuration de la base de données pour les tests
        $this->configureDatabase();

        // Initialisation des gestionnaires
        $this->recipeManager = new Recette($this->db);
        $this->ingredientsManager = new Ingredients($this->db);
    }

    public function configureDatabase(): void
    {
        $this->db = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST'),
                getenv('DB_PORT'),
                getenv('DB_DATABASE')
            ),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
   
    public function testDeleteRecette()
{
    // Insérez une recette pour la supprimer ensuite
    $recipeId = $this->recipeManager->ajouterRecette('Recette de test', 'image_test.jpg', 'Facile', 3, 'Couteau, Planche à découper', 'Étapes de la recette', 1);
    
    // Insérez un ingrédient lié à la recette
    $ingredientId = $this->ingredientsManager->ajouterIngredient('Salade', 2, $recipeId);

    // Suppression de la recette
    $result = $this->recipeManager->deleteRecettes($recipeId);

    // Vérifiez si la suppression a réussi
    $this->assertEquals(1, $result->rowCount());

    // Vérifiez si l'ingrédient lié a également été supprimé
    $ingredient = $this->ingredientsManager->getIngredientById($ingredientId);
    $this->assertFalse($ingredient);
}


    // Test de la fonction ajouterRecette
    public function testAjouterRecette()
    {
        // Préparez les données de test
        $nom = "Test Recipe";
        $image = 'test_image.jpg';
        $difficulte = 'Facile';
        $temps_preparation = 3;
        $ustensiles = 'Couteau, Planche à découper';
        $etapes_recette = 'Étape 1, Étape 2, Étape 3';
        $id_categorie = 1;

        // Appelez la fonction à tester
        $recipeId = $this->recipeManager->ajouterRecette($nom, $image, $difficulte, $temps_preparation, $ustensiles, $etapes_recette, $id_categorie);

        // Vérifiez si l'ajout a réussi
        $this->assertNotEquals(false, $recipeId);

        // Vérifiez si la recette peut être récupérée de la base de données
        $recipe = $this->getRecipeById($recipeId);
        $this->assertNotEmpty($recipe);
    }

private function getRecipeById($id)
{
    try {
        $query = "SELECT * FROM recettes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Vérifiez si une recette a été trouvée
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Gérez l'exception selon vos besoins
        echo "Erreur lors de la récupération de la recette : " . $e->getMessage();
        return false;
    }
}

}
