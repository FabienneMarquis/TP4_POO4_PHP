-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laboratoire3
-- ------------------------------------------------------
-- Server version	5.6.20-log
CREATE SCHEMA IF NOT EXISTS TP4_POO4_PHP;
USE TP4_POO4_PHP;
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
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum` (
  `ForumID` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(128) NOT NULL,
  `horoDate` datetime NOT NULL,
  PRIMARY KEY (`ForumID`),
  UNIQUE KEY `ForumID_UNIQUE` (`ForumID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum`
--

LOCK TABLES `forum` WRITE;
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
INSERT INTO `forum` VALUES (1,'Programmation','0000-00-00 00:00:00'),(2,'Reseau','0000-00-00 00:00:00'),(3,'Etude','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membres` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(32) NOT NULL,
  `mot_de_passe` char(40) NOT NULL,
  `adresse_email` varchar(128) NOT NULL,
  `hash_validation` char(32),
  `date_inscription` date NOT NULL,
  `avatar` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  UNIQUE KEY `adresse_email` (`adresse_email`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `mot_de_passe` (`mot_de_passe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membres`
--

LOCK TABLES `membres` WRITE;
/*!40000 ALTER TABLE `membres` DISABLE KEYS */;
INSERT INTO `membres` VALUES (1,'luc','40bd001563085fc35165329ea1ff5c5ecbdbbeef','l@m.com','','2015-11-09',''),(2,'Paul','40bd001563085fc35165329ea1ff5c5ecbdbbeef','f@m.com','','2015-11-12',''),(3,'Lea','40bd001563085fc35165329ea1ff5c5ecbdbbeef','a@a.com','','2015-11-12','');
/*!40000 ALTER TABLE `membres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `membres_id` int(10) unsigned NOT NULL,
  `parent_messageID` int(11) DEFAULT NULL,
  `horoDate` datetime DEFAULT NULL,
  `forum_ForumID` int(11) NOT NULL,
  `texte` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`messageID`),
  UNIQUE KEY `messageID_UNIQUE` (`messageID`),
  KEY `fk_message_membres1_idx` (`membres_id`),
  KEY `fk_message_message1_idx` (`parent_messageID`),
  KEY `fk_message_forum1_idx` (`forum_ForumID`),
  CONSTRAINT `fk_message_forum1` FOREIGN KEY (`forum_ForumID`) REFERENCES `forum` (`ForumID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_membres1` FOREIGN KEY (`membres_id`) REFERENCES `membres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_message1` FOREIGN KEY (`parent_messageID`) REFERENCES `message` (`messageID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-16 19:55:16



