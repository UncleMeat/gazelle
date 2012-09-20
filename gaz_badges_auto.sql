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
-- Table structure for table `badges_auto`
--

DROP TABLE IF EXISTS `badges_auto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badges_auto` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `BadgeID` int(10) NOT NULL,
  `Action` enum('NumPosts','NumComments','NumUploaded','NumNewTags','NumTags','NumTagVotes','RequestsFilled','UploadedTB','DownloadedTB','MaxSnatches') NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '0',
  `SendPM` tinyint(1) NOT NULL,
  `Value` int(10) NOT NULL,
  `CategoryID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Action` (`Action`),
  KEY `Active` (`Active`),
  KEY `BadgeID` (`BadgeID`),
  KEY `SendPM` (`SendPM`)
) ENGINE=InnoDB AUTO_INCREMENT=319 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badges_auto`
--

LOCK TABLES `badges_auto` WRITE;
/*!40000 ALTER TABLE `badges_auto` DISABLE KEYS */;
INSERT INTO `badges_auto` VALUES (1,12,'NumPosts',0,0,10,0),(3,14,'UploadedTB',0,0,1,0),(4,23,'NumComments',0,1,100,0),(5,24,'NumComments',1,1,250,0),(6,66,'NumComments',1,1,100,0),(7,25,'NumComments',1,1,500,0),(8,67,'NumComments',1,1,1000,0),(9,68,'NumComments',1,1,2500,0),(10,156,'NumUploaded',1,1,100,0),(11,155,'NumUploaded',1,1,200,0),(12,157,'NumUploaded',1,1,400,0),(13,158,'NumUploaded',1,1,800,0),(14,146,'MaxSnatches',1,1,1000,0),(15,147,'MaxSnatches',1,1,5000,0),(16,148,'MaxSnatches',1,1,10000,0),(17,149,'MaxSnatches',1,1,25000,0),(18,150,'UploadedTB',1,1,1,0),(19,151,'UploadedTB',1,1,10,0),(20,152,'UploadedTB',1,1,50,0),(21,153,'UploadedTB',1,1,100,0),(22,154,'UploadedTB',1,1,250,0),(23,79,'DownloadedTB',1,1,1,0),(24,80,'DownloadedTB',1,1,10,0),(25,82,'DownloadedTB',1,1,50,0),(26,81,'DownloadedTB',1,1,100,0),(27,83,'DownloadedTB',1,1,250,0),(28,135,'RequestsFilled',1,1,25,0),(29,136,'RequestsFilled',1,1,100,0),(30,137,'RequestsFilled',1,1,250,0),(31,138,'RequestsFilled',1,1,500,0),(32,166,'NumUploaded',1,1,1600,0),(33,167,'NumUploaded',1,1,3200,0),(34,131,'NumPosts',1,1,250,0),(35,132,'NumPosts',1,1,500,0),(36,130,'NumPosts',1,1,1000,0),(37,133,'NumPosts',1,1,2500,0),(179,36,'NumUploaded',1,1,50,1),(180,37,'NumUploaded',1,1,100,1),(181,38,'NumUploaded',1,1,250,1),(182,39,'NumUploaded',1,1,50,2),(183,40,'NumUploaded',1,1,100,2),(184,41,'NumUploaded',1,1,250,2),(185,42,'NumUploaded',1,1,50,5),(186,43,'NumUploaded',1,1,100,5),(187,44,'NumUploaded',1,1,250,5),(188,45,'NumUploaded',1,1,50,6),(189,46,'NumUploaded',1,1,100,6),(190,47,'NumUploaded',1,1,250,6),(191,48,'NumUploaded',1,1,50,30),(192,49,'NumUploaded',1,1,100,30),(193,50,'NumUploaded',1,1,250,30),(194,51,'NumUploaded',1,1,50,36),(195,52,'NumUploaded',1,1,100,36),(196,53,'NumUploaded',1,1,250,36),(197,54,'NumUploaded',1,1,50,8),(198,55,'NumUploaded',1,1,100,8),(199,56,'NumUploaded',1,1,250,8),(200,57,'NumUploaded',1,1,50,7),(201,58,'NumUploaded',1,1,100,7),(202,59,'NumUploaded',1,1,250,7),(203,60,'NumUploaded',1,1,50,9),(204,61,'NumUploaded',1,1,100,9),(205,62,'NumUploaded',1,1,250,9),(206,63,'NumUploaded',1,1,250,37),(207,64,'NumUploaded',1,1,250,37),(208,65,'NumUploaded',1,1,250,37),(209,72,'NumUploaded',1,1,50,10),(210,73,'NumUploaded',1,1,100,10),(211,74,'NumUploaded',1,1,250,10),(212,84,'NumUploaded',1,1,50,11),(213,85,'NumUploaded',1,1,100,11),(214,86,'NumUploaded',1,1,250,11),(215,88,'NumUploaded',1,1,50,12),(216,89,'NumUploaded',1,1,100,12),(217,90,'NumUploaded',1,1,250,12),(218,91,'NumUploaded',1,1,50,39),(219,92,'NumUploaded',1,1,100,39),(220,93,'NumUploaded',1,1,250,39),(221,94,'NumUploaded',1,1,50,35),(222,95,'NumUploaded',1,1,100,35),(223,96,'NumUploaded',1,1,250,35),(224,97,'NumUploaded',1,1,50,44),(225,98,'NumUploaded',1,1,100,44),(226,99,'NumUploaded',1,1,250,44),(227,100,'NumUploaded',1,1,50,3),(228,101,'NumUploaded',1,1,100,3),(229,102,'NumUploaded',1,1,250,3),(230,103,'NumUploaded',1,1,50,25),(231,104,'NumUploaded',1,1,100,25),(232,105,'NumUploaded',1,1,250,25),(233,106,'NumUploaded',1,1,50,43),(234,107,'NumUploaded',1,1,100,43),(235,108,'NumUploaded',1,1,250,43),(236,139,'NumUploaded',1,1,50,22),(237,140,'NumUploaded',1,1,100,22),(238,141,'NumUploaded',1,1,250,22),(239,109,'NumUploaded',1,1,50,16),(240,110,'NumUploaded',1,1,100,16),(241,111,'NumUploaded',1,1,250,16),(242,112,'NumUploaded',1,1,50,23),(243,113,'NumUploaded',1,1,100,23),(244,114,'NumUploaded',1,1,250,23),(245,115,'NumUploaded',1,1,50,52),(246,116,'NumUploaded',1,1,100,52),(247,117,'NumUploaded',1,1,250,52),(248,118,'NumUploaded',1,1,50,27),(249,119,'NumUploaded',1,1,100,27),(250,120,'NumUploaded',1,1,250,27),(251,121,'NumUploaded',1,1,50,53),(252,122,'NumUploaded',1,1,100,53),(253,123,'NumUploaded',1,1,250,53),(254,124,'NumUploaded',1,1,50,40),(255,125,'NumUploaded',1,1,100,40),(256,126,'NumUploaded',1,1,250,40),(257,127,'NumUploaded',1,1,50,14),(258,128,'NumUploaded',1,1,100,14),(259,129,'NumUploaded',1,1,250,14),(260,168,'NumUploaded',1,1,50,18),(261,169,'NumUploaded',1,1,100,18),(262,170,'NumUploaded',1,1,250,18),(263,171,'NumUploaded',1,1,50,26),(264,172,'NumUploaded',1,1,100,26),(265,173,'NumUploaded',1,1,250,26),(266,174,'NumUploaded',1,1,50,17),(267,175,'NumUploaded',1,1,100,17),(268,176,'NumUploaded',1,1,250,17),(269,177,'NumUploaded',1,1,50,41),(270,178,'NumUploaded',1,1,100,41),(271,179,'NumUploaded',1,1,250,41),(272,180,'NumUploaded',1,1,50,29),(273,181,'NumUploaded',1,1,100,29),(274,182,'NumUploaded',1,1,250,29),(275,183,'NumUploaded',1,1,50,47),(276,184,'NumUploaded',1,1,100,47),(277,185,'NumUploaded',1,1,250,47),(278,186,'NumUploaded',1,1,50,24),(279,187,'NumUploaded',1,1,100,24),(280,188,'NumUploaded',1,1,250,24),(281,189,'NumUploaded',1,1,50,21),(282,190,'NumUploaded',1,1,100,21),(283,191,'NumUploaded',1,1,250,21),(284,192,'NumUploaded',1,1,50,50),(285,193,'NumUploaded',1,1,100,50),(286,194,'NumUploaded',1,1,250,50),(287,198,'NumUploaded',1,1,50,46),(288,199,'NumUploaded',1,1,100,46),(289,200,'NumUploaded',1,1,250,46),(290,201,'NumUploaded',1,1,50,51),(291,202,'NumUploaded',1,1,100,51),(292,203,'NumUploaded',1,1,250,51),(293,204,'NumUploaded',1,1,50,15),(294,205,'NumUploaded',1,1,100,15),(295,206,'NumUploaded',1,1,250,15),(296,207,'NumUploaded',1,1,50,20),(297,208,'NumUploaded',1,1,100,20),(298,209,'NumUploaded',1,1,250,20),(299,210,'NumUploaded',1,1,50,49),(300,211,'NumUploaded',1,1,100,49),(301,212,'NumUploaded',1,1,250,49),(302,213,'NumUploaded',1,1,50,34),(303,214,'NumUploaded',1,1,100,34),(304,215,'NumUploaded',1,1,250,34),(305,216,'NumUploaded',1,1,50,19),(306,217,'NumUploaded',1,1,100,19),(307,218,'NumUploaded',1,1,250,19),(308,219,'NumUploaded',1,1,50,45),(309,220,'NumUploaded',1,1,100,45),(310,221,'NumUploaded',1,1,250,45),(311,222,'NumUploaded',1,1,50,13),(312,223,'NumUploaded',1,1,100,13),(313,224,'NumUploaded',1,1,250,13),(314,195,'NumUploaded',1,1,50,55),(315,196,'NumUploaded',1,1,100,55),(316,197,'NumUploaded',1,1,250,55),(317,231,'NumPosts',1,1,5000,0),(318,232,'NumPosts',1,1,10000,0);
/*!40000 ALTER TABLE `badges_auto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-20 10:52:24
