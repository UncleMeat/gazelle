-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gazelle
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

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
-- Table structure for table `bonus_shop_actions`
--

DROP TABLE IF EXISTS `bonus_shop_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus_shop_actions` (
  `ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(256) NOT NULL,
  `Description` varchar(1024) NOT NULL,
  `Action` enum('gb','givegb','givecredits','slot','title','badge','pfl','ufl') NOT NULL,
  `Value` int(10) NOT NULL DEFAULT '0',
  `Cost` int(9) unsigned NOT NULL,
  `Sort` int(6) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Sort` (`Sort`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_shop_actions`
--

LOCK TABLES `bonus_shop_actions` WRITE;
/*!40000 ALTER TABLE `bonus_shop_actions` DISABLE KEYS */;
INSERT INTO `bonus_shop_actions` VALUES (1,'Give Away 500 Credits','If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 500 credits.','givecredits',500,505,3),(2,'Give Away 2000 Credits','If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 2000 credits.','givecredits',2000,2020,4),(3,'Give away 5000 credits','If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 5000 credits.','givecredits',5000,5050,6),(4,'-1 GB','Do you have a bad ratio? Here you can improve it dramatically by buying 1GB away from what you\'ve downloaded!','gb',1,500,10),(5,'-5GB','Do you have a bad ratio? Here you can improve it dramatically by buying 5GB away from what you\'ve downloaded!','gb',5,2000,12),(6,'-10GB','Do you have a bad ratio? Here you can improve it dramatically by buying 10GB away from what you\'ve downloaded!','gb',10,4000,18),(7,'-1GB to other','Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 1GB from the person\'s downloaded traffic!','givegb',1,505,20),(8,'-5GB to other','Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 5GB from the person\'s downloaded traffic!','givegb',5,2020,22),(9,'-10 GB to other','Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 10GB from the person\'s downloaded traffic!','givegb',10,4040,25),(10,'1 Slot','A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.','slot',1,6000,30),(11,'2 Slots','A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.','slot',2,12000,31),(12,'Custom Title','A super seeder like you deserves a custom title on the tracker!','title',1,20000,50),(25,'24 hour PFL','Personal FreeLeech - Download as many torrents you want for 24 hours without counting the downloaded amount.','pfl',24,20000,40),(33,'Bling 100k','Check out this awesome Bling!','badge',6,100000,100),(34,'Bling 250k','Check out this awesome Bling!','badge',7,250000,101),(35,'Bling 500k','Check out this awesome Bling!','badge',8,500000,102),(36,'Bling 750k','Check out this awesome Bling!','badge',9,750000,103),(38,'Wealthy Wanker','Plaque of Wealth. This user is a wealthy wanker. This is a placeholder! we need better text & gfx!','badge',19,0,105),(39,'Filthy Rich','Plaque of Richness. This user is filthy rich. This is a placeholder! we need better text &amp; gfx!','badge',20,400000,106),(40,'Awesome Muthafucka','Plaque of Awesomeness. This user is an awesome muthafucka. This is a placeholder! we need better text & gfx!','badge',21,0,107),(41,'Millionaires','Millionaires Plaque. This user is a millionaire. This is a placeholder! we need better text &amp; gfx!','badge',22,1000000,108),(42,'Freeleech torrent','Make a torrent of yours freeleech for everyone permanently','ufl',1,70000,34);
/*!40000 ALTER TABLE `bonus_shop_actions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-20 10:53:01
