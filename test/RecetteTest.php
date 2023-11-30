<?php
include_once 'src/Recette.php';

use PHPUnit\Framework\TestCase;

class RecetteTest extends TestCase

{

    public function setUp(): void{
        $this->configureDatabase();
        $this->userManager = new Recette ($this->db);


    }
    private function configureDatabase():void {
        $this->db = new DB(sprintf(
            'mysql:host=%s;port=%d;dbname=%s',
            getenv('DB_HOST'),
            getenv('DB_PORT'),
            getenv('DB_DATABASE')
        ), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    // here we going to test the delete recette function
    public function testDeleteRecette()
    {
        $result = $this->userManager->deleteRecettes(1);
        $this->assertEquals(1, $result->rowCount());
    }

}