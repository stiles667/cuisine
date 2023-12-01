<?php
require_once 'src/Recette.php';

use PHPUnit\Framework\TestCase;

class RecetteTest extends TestCase
{
    private $userManager;
    private $db;

    public function setUp(): void
    {
        // Configuration de la base de données pour les tests
        $this->configureDatabase();
        $this->userManager = new Recette($this->db);
    }

    private function configureDatabase(): void
    {
        
        $this->db = new PDO('mysql:host=localhost;dbname=test_database;charset=utf8', 'username', 'password');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Test de la fonction deleteRecettes
    public function testDeleteRecette()
    {
       
        $this->userManager->ajouterRecette(/* paramètres de la recette */);

        
        $lastInsertedId = $this->db->lastInsertId();

        // Suppression de la recette
        $result = $this->userManager->deleteRecettes($lastInsertedId);

        
        $this->assertEquals(1, $result->rowCount());
    }

    // Test de la fonction ajouterRecette
    public function testAjouterRecette()
    {
        
        $result = $this->userManager->ajouterRecette(/* paramètres de la recette */);

        
        $this->assertNotEquals(false, $result);
    }
}
