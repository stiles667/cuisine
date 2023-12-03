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
        
        $this->db = new PDO('mysql:host=localhost;dbname=cuisine;charset=utf8', 'root', '1Aqzsedrf!');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    // Test de la fonction deleteIngredient
    public function testDeleteIngredient()
{
    // ID d'ingrédient fictif à supprimer
    $ingredientId = 6;

    // Appel de la fonction deleteIngredient
    $result = $this->ingredientsManager->deleteIngredient($ingredientId);

    $this->assertTrue($result !== false, "La suppression de l'ingrédient a échoué.");
}

  
    // Test de la fonction getIngredientById
    public function testGetIngredientById()
    {
        // ID d'ingrédient fictif à récupérer
        $ingredientId = 9;

        // Appel de la fonction getIngredientById
        $result = $this->ingredientsManager->getIngredientById($ingredientId);

        // Vérification si l'ingrédient récupéré a le bon ID (par exemple, vérifier le contenu de $result)
        $this->assertEquals($ingredientId, $result['id']);
    }


    
    // public function testEditQuantiteIngredient()
    // {
    //     // Paramètres fictifs
    //     $idRecetteIngredient = 1;
    //     $idRecette = 1;
    //     $idIngredient = 1;
    //     $nouvelleQuantite = 3;

        
    //     $result = $this->ingredientsManager->editQuantiteIngredient($idRecetteIngredient, $idRecette, $idIngredient, $nouvelleQuantite);

        
    //     $this->assertNotNull($result);
    // }
}
