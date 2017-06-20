-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: library
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `birth_date` date DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'J. K. Rowling','1965-07-31','http://www.ofrases.com/imagenes/JK_Rowling.jpg',NULL),(2,'Suzanne Collins',NULL,NULL,NULL),(3,'Christopher Paolini','1983-09-17',NULL,'Christopher Paolini, né le 17 novembre 1983 à Los Angeles en Californie, est un écrivain américain de fantasy'),(4,'Markus Zusak','1975-06-23','http://www.orderofbooks.com/wp-content/uploads/2013/07/Markus-Zusak.jpg','Markus Zusak, né le 23 juin 1975 à Sydney, est un écrivain australien de romans pour jeunes adultes. Il a notamment écrit La Voleuse de livres, bestseller des livres pour enfants et pour adultes en 2007');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) CHARACTER SET utf8 NOT NULL,
  `synopsis` mediumtext CHARACTER SET utf8,
  `tags` tinytext CHARACTER SET utf8,
  `authors_id` int(11) NOT NULL,
  `series_id` int(11) DEFAULT NULL,
  `genres_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_books_authors1_idx` (`authors_id`),
  KEY `fk_books_series1_idx` (`series_id`),
  KEY `fk_books_genres1_idx` (`genres_id`),
  CONSTRAINT `fk_books_authors1` FOREIGN KEY (`authors_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_books_genres1` FOREIGN KEY (`genres_id`) REFERENCES `genres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_books_series1` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Harry Potter à l\'école des sorciers','Le jour de ses onze ans, Harry Potter, un orphelin élevé par un oncle et une tante qui le détestent, voit son existence bouleversée. Un géant vient le chercher pour l\'emmener au collège Poudlard, école de sorcellerie où une place l\'attend depuis toujours. Qui est donc Harry Potter ? Et qui est l\'effroyable V..., le mage dont personne n\'ose prononcer le nom ?','magie,sorciers',1,NULL,2),(2,'Hunger Games','Dans le district de Panem, deux adolescents participent au jeu de la Faim. Le vainqueur des épreuves est le dernier survivant. Katniss et Peeta sont les \"élus\" du district numéro 12. Ils sont alors chargés de la prospérité de la localité pendant une année... Alors que le jeu télévisé n’est pas tout à fait terminé, Peeta déclare sa flamme à Katniss. Mais ce jeu n’autorise qu’un seul gagnant...','injustice,rébellion',2,NULL,19),(3,'Eragon','Alors qu\'il chasse sur la Crête, une chaîne de montagnes réputée maléfique, Eragon, un jeune paysan âgé de 15 ans, découvre dans une clairière une mystérieuse pierre bleue parcourue de veines blanches. Cette pierre se révèle en vérité être un œuf duquel ne tarde pas à émerger une dragonne bleue. Eragon, modeste paysan, devient alors le premier représentant depuis des décennies des légendaires Dragonniers disparus depuis plus de cent ans.','dragon,magie',3,NULL,1),(4,'L\'aîné','Eragon et sa dragonne, Saphira, sortent à peine de la victoire de Farthen Dûr contre les Urgals qu’une nouvelle horde de monstres apparaît. Ajihad, le chef des Vardens, est tué. Nommée par le conseil des Anciens, sa fille, Nasuada, prend la tête des rebelles. Eragon et Saphira lui prêtent allégeance avant d’entreprendre un voyage vers le royaume des elfes, à Ellesméra.','dragon,magie,elfe',3,NULL,1),(5,'Brisingr','Eragon a une double promesse à tenir : aider Roran à délivrer sa fiancée, Katrina, prisonnière des Ra’zacs, et venger la mort de son oncle Garrow. Saphira emmène les deux cousins jusqu’à Helgrind, les Portes de la Mort, repaire des monstres. Or, depuis que Murtagh lui a repris Zar’oc, l’épée que Brom lui avait donnée, Eragon n’est plus armé que du bâton du vieux conteur.','dragon,magie,elfe',3,NULL,1),(6,'L\'Héritage',NULL,'dragon,magie,elfe,crypte,âmes',3,NULL,1);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books_versions`
--

DROP TABLE IF EXISTS `books_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books_versions` (
  `ISBN` varchar(45) CHARACTER SET utf8 NOT NULL,
  `publication` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lang` varchar(45) CHARACTER SET utf8 NOT NULL,
  `copies` int(11) NOT NULL DEFAULT '1',
  `description` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `page_number` int(11) NOT NULL,
  `books_id` int(11) NOT NULL,
  PRIMARY KEY (`ISBN`),
  KEY `fk_books_versions_books1_idx` (`books_id`),
  CONSTRAINT `fk_books_versions_books1` FOREIGN KEY (`books_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books_versions`
--

LOCK TABLES `books_versions` WRITE;
/*!40000 ALTER TABLE `books_versions` DISABLE KEYS */;
INSERT INTO `books_versions` VALUES ('ISBN: 0-7475-3274-5','London : Bloomsbury, 1997','http://images-eu.amazon.com/images/P/0747532745.01.LZZZZZZZ.jpg','Anglais',3,'original UK Paperback (Soft Cover) edition',222,1),('ISBN: 978-2-070-64302-8','Folio Junior septembre 2011','https://images-na.ssl-images-amazon.com/images/I/51PHEMHZZ8L._SX346_BO1,204,203,200_.jpg','Français',1,'Poche ; 2,2 x 1,5 x 17,5 cm',320,1),('ISBN: 978-2-266-18269-0','Paris : Pocket jeunesse, impr. 2009','http://www.culturewok.com/content/covers/e4b0e4c48878d2897372e96c71611cfb.jpg','Français',1,'couv. ill. en coul. ; 23 cm',398,2),('ISBN: 978-2-7470-1440-3','Paris : Bayard jeunesse, 2004','https://media.biblys.fr/book/21/16821.jpg','Français',1,'carte, couv. ill. en coul. ; 23 cm',698,3),('ISBN: 978-2-7470-1455-7','Paris : Bayard jeunesse, impr. 2006',NULL,'Français',6,'carte, couv. ill. en coul. ; 23 cm',808,4),('ISBN: 978-2-7470-1456-4','Montrouge : Bayard jeunesse, DL 2009, Impr. Brodard & Taupin',NULL,'Français',2,'couv. ill. en coul. ; 23 cm',826,5),('ISBN: 978-2-7470-2121-0','Montrouge : Bayard jeunesse, DL 2014',NULL,'Français',1,'carte, couv. ill. en coul. ; 18 cm',902,6);
/*!40000 ALTER TABLE `books_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `borrowings`
--

DROP TABLE IF EXISTS `borrowings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowing_date` date NOT NULL,
  `deadline_for_return` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `users_bar_code` int(6) NOT NULL,
  `books_versions_ISBN` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_borrowings_books_versions1_idx` (`books_versions_ISBN`),
  KEY `fk_borrowings_users1_idx` (`users_bar_code`),
  CONSTRAINT `fk_borrowings_books_versions1` FOREIGN KEY (`books_versions_ISBN`) REFERENCES `books_versions` (`ISBN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_borrowings_users1` FOREIGN KEY (`users_bar_code`) REFERENCES `users` (`bar_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `borrowings`
--

LOCK TABLES `borrowings` WRITE;
/*!40000 ALTER TABLE `borrowings` DISABLE KEYS */;
INSERT INTO `borrowings` VALUES (1,'2017-06-19','2017-07-19',NULL,123456,'ISBN: 0-7475-3274-5'),(2,'2017-06-19','2017-07-19',NULL,123456,'ISBN: 0-7475-3274-5'),(3,'2017-06-20','2017-07-20',NULL,123456,'ISBN: 978-2-070-64302-8'),(4,'2017-06-20','2017-07-20',NULL,123456,'ISBN: 978-2-7470-1455-7');
/*!40000 ALTER TABLE `borrowings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` int(11) NOT NULL,
  `comment` tinytext CHARACTER SET utf8,
  `users_bar_code` int(6) NOT NULL,
  `books_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_books1_idx` (`books_id`),
  KEY `fk_comments_users1_idx` (`users_bar_code`),
  CONSTRAINT `fk_comments_books1` FOREIGN KEY (`books_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`users_bar_code`) REFERENCES `users` (`bar_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,'Fantasy'),(2,'Fantastique'),(3,'Classique'),(4,'Erotique'),(5,'Espionnage'),(6,'Guerre'),(7,'Horreur'),(8,'Policier'),(9,'Science-Fiction'),(10,'Thriller'),(11,'Western'),(12,'Bande Dessinée'),(13,'Manga'),(14,'Sport'),(15,'Humour'),(16,'Poème'),(17,'Esotérisme'),(18,'Santé & Bien-être'),(19,'Dystopie');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `content` tinytext CHARACTER SET utf8 NOT NULL,
  `users_bar_code` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notifications_users1_idx` (`users_bar_code`),
  CONSTRAINT `fk_notifications_users1` FOREIGN KEY (`users_bar_code`) REFERENCES `users` (`bar_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `user_bar_code` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscriptions_users1_idx` (`user_bar_code`),
  CONSTRAINT `fk_subscriptions_users1` FOREIGN KEY (`user_bar_code`) REFERENCES `users` (`bar_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,'2017-06-18','2018-06-18',123456),(2,'2018-06-18','2018-07-18',123456),(3,'2018-07-18','2018-09-18',123456);
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `bar_code` int(6) NOT NULL,
  `password` char(64) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(45) CHARACTER SET utf8 NOT NULL,
  `postal_code` int(4) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `is_bloqued` tinyint(1) DEFAULT '0',
  `creating_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleting_date` datetime DEFAULT NULL,
  PRIMARY KEY (`bar_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (123456,'b818a1c8bd18504e32265ef9ca3c2df704bd5a884c9d2781186ec9f7a07f8424','Jane','Doe','jane.doe@gmail.com','Liège',4000,'Rue des Guillemins, 15',1,0,'2017-06-15 07:58:12',NULL),(739154,'581224d1745c76c0f314cf21b8637bdfca796ee0ac2b34a9d33227aee00eabee','John','Doe','john.doe@gmail.com','Liège',4000,'Rue des Guillemins, 15',0,0,'2017-06-20 21:36:08',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-21  0:11:30
