CREATE DATABASE  IF NOT EXISTS `appendectomy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `appendectomy`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: www.uisltsc.com.tw    Database: appendectomy
-- ------------------------------------------------------
-- Server version	5.0.41-community-nt

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `test_record`
--

DROP TABLE IF EXISTS `test_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_record` (
  `test_record_id` int(11) NOT NULL auto_increment,
  `serial_no` varchar(15) NOT NULL,
  `tester` varchar(30) NOT NULL,
  `mail_method` enum('NORMAL','REGISTERED','ADV','PRI','PRI_REG') default 'NORMAL',
  `city` varchar(20) default NULL,
  `district` varchar(20) default NULL,
  `send_location` varchar(255) default NULL,
  `send_date` datetime default NULL,
  `received_date` datetime default NULL,
  `reg_no` varchar(30) default NULL,
  PRIMARY KEY  (`test_record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_record`
--

LOCK TABLES `test_record` WRITE;
/*!40000 ALTER TABLE `test_record` DISABLE KEYS */;
INSERT INTO `test_record` VALUES (7,'AP103000021','sw','NORMAL',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `test_record` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-13 22:34:36
