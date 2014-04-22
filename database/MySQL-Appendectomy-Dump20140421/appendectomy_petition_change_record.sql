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
-- Table structure for table `petition_change_record`
--

DROP TABLE IF EXISTS `petition_change_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petition_change_record` (
  `petition_change_record_id` int(11) NOT NULL auto_increment,
  `petition_id` int(11) NOT NULL,
  `status_changed_to` enum('received','sent','refused','voided') NOT NULL default 'received',
  `changed_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `staff_id` int(11) NOT NULL,
  `succeed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`petition_change_record_id`),
  KEY `petition_record_to_petition_idx` (`petition_id`),
  KEY `petition_record_to_staff_idx` (`staff_id`),
  CONSTRAINT `petition_record_to_petition` FOREIGN KEY (`petition_id`) REFERENCES `petition` (`petition_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `petition_record_to_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff_info` (`staff_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petition_change_record`
--

LOCK TABLES `petition_change_record` WRITE;
/*!40000 ALTER TABLE `petition_change_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `petition_change_record` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-21  1:03:47
