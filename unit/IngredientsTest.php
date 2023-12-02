<?php
include ('./src/Ingredients.php');

use PHPUnit\Framework\TestCase;

class IngredientsTest extends TestCase
{
    private $ingredientsManager;
    private $db;

    public function setUp(): void
    {
        // Configuration de la base de données pour les tests
        $this->configureDatabase();
        $this->ingredientsManager = new Ingredients($this->db);
    }

    private function configureDatabase(): void
    {
        
        $this->db = new PDO('mysql:host=localhost;dbname=test_database;charset=utf8', 'username', 'password');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Test de la fonction ajouterRecetteIngredient
    public function testAjouterRecetteIngredient()
    {
        // Paramètres fictifs
        $recette_id = 1;
        $ingredient_id = 1;
        $quantite = 2;

        // Appel de la fonction ajouterRecetteIngredient
        $result = $this->ingredientsManager->ajouterRecetteIngredient($recette_id, $ingredient_id, $quantite);

        
        $this->assertNotNull($result);
    }

    // Test de la fonction deleteIngredient
    public function testDeleteIngredient()
    {
        // ID d'ingrédient fictif à supprimer
        $ingredientId = 1;

        // Appel de la fonction deleteIngredient
        $result = $this->ingredientsManager->deleteIngredient($ingredientId);

        // Vérification si la suppression a été effectuée avec succès
        $this->assertNotNull($result);
    }

    // Test de la fonction getIngredientById
    public function testGetIngredientById()
    {
        // ID d'ingrédient fictif à récupérer
        $ingredientId = 1;

        // Appel de la fonction getIngredientById
        $result = $this->ingredientsManager->getIngredientById($ingredientId);

        // Vérification si l'ingrédient récupéré a le bon ID (par exemple, vérifier le contenu de $result)
        $this->assertEquals($ingredientId, $result['id']);
    }

    // Test de la fonction editIngredient
    public function testEditIngredient()
    {
        // ID et nom d'ingrédient fictifs à éditer
        $ingredientId = 1;
        $nouveauNom = "Nouveau Nom";

        // Appel de la fonction editIngredient
        $result = $this->ingredientsManager->editIngredient($ingredientId, $nouveauNom);

        
        $this->assertNotNull($result);
    }

    
    public function testEditQuantiteIngredient()
    {
        // Paramètres fictifs
        $idRecetteIngredient = 1;
        $idRecette = 1;
        $idIngredient = 1;
        $nouvelleQuantite = 3;

        
        $result = $this->ingredientsManager->editQuantiteIngredient($idRecetteIngredient, $idRecette, $idIngredient, $nouvelleQuantite);

        
        $this->assertNotNull($result);
    }
}
