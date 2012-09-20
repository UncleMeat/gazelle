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
-- Table structure for table `do_not_upload`
--

DROP TABLE IF EXISTS `do_not_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `do_not_upload` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `UserID` int(10) NOT NULL,
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Time` (`Time`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `do_not_upload`
--

LOCK TABLES `do_not_upload` WRITE;
/*!40000 ALTER TABLE `do_not_upload` DISABLE KEYS */;
INSERT INTO `do_not_upload` VALUES (1,'NO Underage (below 18) content.','',84499,'2012-07-23 17:35:39'),(2,'NO True Rape.','',84499,'2012-07-23 17:35:55'),(3,'NO Beast.','',84499,'2012-07-23 17:36:02'),(4,'No Snuff.','',84499,'2012-07-23 17:36:10'),(5,'No Main Stream Content Allowed.','',84499,'2012-07-23 17:36:16'),(6,'NO Child Birth.','',84499,'2012-07-23 17:36:22'),(7,'NO .exe Files except porn games.','',84499,'2012-07-23 17:37:10'),(8,'NO Password protected files or folders.','',84499,'2012-07-23 17:37:22'),(9,'NO videos in Zips/Rars, >250 pics only.','No Archived media except for large pictorrents.+250 pics.(uploaders choice)',84499,'2012-07-23 17:38:14'),(10,'No rar Scene releases','No rar Scene releases,you need to unrar them to make screens anyway.',84499,'2012-07-23 17:38:39'),(11,'Nothing from the specific list =>','[b]IMPORTANT!:[/b] Check [url=/articles.php?topic=forbiddencontent#specific]The forbidden sites and actors list[/url]',84499,'2012-07-24 20:16:10');
/*!40000 ALTER TABLE `do_not_upload` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-20 10:53:45
