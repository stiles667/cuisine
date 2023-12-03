-- MariaDB dump 10.19-11.1.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cuisine
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Entrées'),
(2,'Plats principaux'),
(3,'Desserts'),
(4,'Soupes'),
(5,'Plats végétariens');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `recette_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recette_id` (`recette_id`),
  CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`recette_id`) REFERENCES `recettes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES
(44,'Quinoa',NULL),
(45,'Concombre',NULL),
(46,'Poivron rouge',NULL),
(47,'Persil frais',NULL),
(48,'Huile d\'olive (cuillere)',NULL),
(49,'Jus de citron (cuillere)',NULL),
(50,'Gousse d\'ail',NULL),
(51,'Filets de poulet (en gramme)',NULL),
(52,'Oignon',NULL),
(53,'Ail',NULL),
(54,'Curry en poudre (cuillere a soupe)',NULL),
(55,'Lait de coco (en ml)',NULL),
(56,'Huile végétale',NULL),
(57,'Coriandre fraîche pour garnir',NULL),
(58,'Pâte brisée',NULL),
(59,'Pommes',NULL),
(60,'Sucre ( en gramme) ',NULL),
(61,'Cannelle en poudre ( cuillère a café)',NULL),
(62,'Beurre ( en gramme)',NULL),
(63,'Baguette de pain',NULL),
(64,'Tomates',NULL),
(65,'Ai',NULL),
(66,'Basilic frais',NULL),
(67,'Huile d\'olive ( cuillère a soupe )',NULL),
(68,'sel',NULL),
(69,'Poivre',NULL),
(70,'œufs',NULL),
(71,'poignée de champignons tranchés',NULL),
(72,'cuillère à soupe d\'huile d\'olive',NULL),
(73,'Sel et poivre au goût',NULL),
(74,'1/4 tasse de fromage râpé (facultatif)',NULL),
(75,'Tomates (kg)',NULL),
(76,'oignon moyen, haché',NULL),
(77,'gousses d\'ail, émincées',NULL),
(78,'cuillères à soupe d\'huile d\'olive',NULL),
(79,'bouillon de légumes (ml)',NULL),
(80,'cuillère à café de sucre',NULL),
(81,'cuillère à café d\'origan séché',NULL);
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recette_ingredient`
--

DROP TABLE IF EXISTS `recette_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recette_ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recette_id` int(11) DEFAULT NULL,
  `ingredient_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recette_id` (`recette_id`),
  KEY `ingredient_id` (`ingredient_id`),
  CONSTRAINT `recette_ingredient_ibfk_1` FOREIGN KEY (`recette_id`) REFERENCES `recettes` (`id`),
  CONSTRAINT `recette_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recette_ingredient`
--

LOCK TABLES `recette_ingredient` WRITE;
/*!40000 ALTER TABLE `recette_ingredient` DISABLE KEYS */;
INSERT INTO `recette_ingredient` VALUES
(9,18,44,1),
(10,18,45,1),
(11,18,46,1),
(12,18,47,1),
(13,18,48,3),
(14,18,49,2),
(15,18,50,1),
(16,19,51,500),
(17,19,52,1),
(18,19,53,2),
(19,19,54,2),
(20,19,55,400),
(21,19,56,2),
(22,19,57,1),
(23,20,58,1),
(24,20,59,4),
(25,20,60,4),
(26,20,61,0),
(27,20,62,30),
(28,21,63,1),
(29,21,64,3),
(30,21,65,2),
(31,21,66,1),
(32,21,67,3),
(33,21,68,1),
(34,21,69,0),
(43,26,75,1),
(44,26,76,1),
(45,26,77,2),
(46,26,78,2),
(47,26,79,500),
(48,26,80,1),
(49,26,81,1);
/*!40000 ALTER TABLE `recette_ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recettes`
--

DROP TABLE IF EXISTS `recettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recettes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `difficulte` varchar(255) DEFAULT NULL,
  `temps_preparation` int(11) DEFAULT NULL,
  `ustensiles` varchar(255) DEFAULT NULL,
  `etapes_recette` text DEFAULT NULL,
  `id_categorie` int(11) DEFAULT NULL,
  `id_ingredient` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categorie` (`id_categorie`),
  KEY `id_ingredient` (`id_ingredient`),
  CONSTRAINT `recettes_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`),
  CONSTRAINT `recettes_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recettes`
--

LOCK TABLES `recettes` WRITE;
/*!40000 ALTER TABLE `recettes` DISABLE KEYS */;
INSERT INTO `recettes` VALUES
(18,'Salade de Quinoa Méditerranéenne','https://hellonelo.com/wp-content/uploads/2023/05/hellonelo-salade-mediterraneenne-saumon-2.jpg','Facile',20,'Casserole, Saladier, Cuillère à mélanger, Couteau de cuisine, Planche à découper','Cuisson du quinoa:\r\n\r\nRincer 1 tasse de quinoa sous l\'eau froide pour enlever l\'amertume.\r\nDans une casserole, porter à ébullition 2 tasses d\'eau salée.\r\nAjouter le quinoa et réduire à feu doux. Couvrir et laisser mijoter pendant 15 minutes jusqu\'à absorption complète de l\'eau.\r\nRetirer du feu et laisser reposer à couvert pendant 5 minutes. Égrener à l\'aide d\'une fourchette et laisser refroidir.\r\nPréparation des légumes:\r\n\r\nCouper en petits dés 1 concombre, 1 poivron rouge et 1 tomate.\r\nHacher finement 1 oignon rouge.\r\nCiseler quelques feuilles de persil frais.\r\nPréparation de la vinaigrette:\r\n\r\nDans un petit bol, mélanger 3 cuillères à soupe d\'huile d\'olive, 2 cuillères à soupe de jus de citron, 1 gousse d\'ail émincée, du sel et du poivre.\r\nAssemblage de la salade:\r\n\r\nDans un grand saladier, combiner le quinoa refroidi, les légumes préparés et la vinaigrette.\r\nAjouter quelques olives noires dénoyautées et des dés de fromage feta (en option).\r\nMélanger délicatement pour bien enrober tous les ingrédients.\r\nRéfrigération et service:\r\n\r\nCouvrir le saladier et réfrigérer pendant au moins 30 minutes pour permettre aux saveurs de se mélanger.\r\nServir frais, garni de feuilles de persil supplémentaires si désiré.',1,NULL),
(19,'Poulet au Curry','https://cdn.chefclub.tools/uploads/recipes/cover-thumbnail/f287b191-dc8e-4c85-bbb6-e26387c354d3.jpg','Moyenne',40,'','Faire chauffer l\'huile dans une poêle, faire revenir l\'oignon et l\'ail hachés jusqu\'à ce qu\'ils soient dorés.\r\nAjouter le poulet coupé en morceaux et le faire dorer.\r\nSaupoudrer de curry, saler et poivrer.\r\nVerser le lait de coco, laisser mijoter pendant 20 minutes.\r\nServir garni de coriandre fraîche, accompagné de riz basmati.',2,NULL),
(20,'Tarte aux Pommes','https://www.yumelise.fr/wp-content/uploads/2023/05/tarte-normande-aux-pommes.jpg','Facile',60,'','Préchauffer le four à 180°C.\r\nÉtaler la pâte dans un moule à tarte.\r\nÉplucher et couper les pommes en tranches, les disposer sur la pâte.\r\nSaupoudrer de sucre et de cannelle, parsemer de beurre en petits morceaux.\r\nEnfourner pendant 40 minutes jusqu\'à ce que la tarte soit dorée.',1,NULL),
(21,'Bruschetta à la Tomate','https://assets.afcdn.com/recipe/20210401/119043_w1024h1024c1cx707cy1060cxt0cyt0cxb1414cyb2121.webp','Facile',15,'','rancher la baguette en morceaux, les faire toaster.\r\nFrotter l\'ail sur les tranches de pain.\r\nCouper les tomates en dés, les mélanger avec l\'huile d\'olive, le basilic, le sel et le poivre.\r\nDéposer ce mélange sur les tranches de pain.',1,NULL),
(26,'Soupe de tomates maison','https://cache.marieclaire.fr/data/photo/w1000_c17/cuisine/i13_ratrap_img1/35822701.jpg','Facile',15,'Couteau de cuisine  Planche à découper  Casserole ou marmite  Cuillère en bois : Mixeur plongeant Tamis ou passoire fine (optionnel)  Cuillère à fente  Louche ','Faire bouillir de l\'eau dans une casserole. Pendant ce temps, inciser une croix peu profonde sur la base de chaque tomate. Plonger les tomates dans l\'eau bouillante pendant environ 1 minute, puis les retirer avec une cuillère à fente et les plonger immédiatement dans de l\'eau glacée. Cela facilitera l\'épluchage des tomates. Retirer la peau des tomates, les couper grossièrement et réserver.\r\nDans une grande casserole, chauffer l\'huile d\'olive à feu moyen. Ajouter l\'oignon haché et faire revenir jusqu\'à ce qu\'il soit translucide.\r\nAjouter l\'ail émincé et laisser cuire quelques instants jusqu\'à ce qu\'il soit parfumé.\r\nIncorporer les tomates coupées en dés dans la casserole. Ajouter le sucre, l\'origan séché, le bouillon de légumes, du sel et du poivre. Porter à ébullition, puis réduire le feu et laisser mijoter pendant environ 10-15 minutes jusqu\'à ce que les tomates soient bien cuites.\r\nRetirer la casserole du feu et laisser refroidir légèrement.\r\nUtiliser un mixeur plongeant pour réduire le mélange en purée lisse. Si vous préférez une texture plus fine, passer la soupe à travers un tamis ou une passoire fine pour retirer les pépins et les morceaux restants.\r\nRemettre la soupe sur le feu pour la réchauffer légèrement si nécessaire. Rectifier l\'assaisonnement si besoin.\r\nServir chaud, garni de feuilles de basilic frais si désiré.',4,NULL);
/*!40000 ALTER TABLE `recettes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-03 18:18:55
