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
-- Table structure for table `staff_info`
--

DROP TABLE IF EXISTS `staff_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_info` (
  `staff_id` int(11) NOT NULL auto_increment,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `elect_district_id` int(11) default NULL,
  `city_id` int(11) default NULL,
  `district_id` int(11) default NULL,
  `village_id` int(11) default NULL,
  `level` enum('admin','normal','reg_admin') default 'normal',
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `UNIQUE_NICKNAME` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_info`
--

LOCK TABLES `staff_info` WRITE;
/*!40000 ALTER TABLE `staff_info` DISABLE KEYS */;
INSERT INTO `staff_info` VALUES (1,'*4ACFE3202A5FF5CF467898FC58AAB1D615029441','admin@admin.admin','admin',NULL,NULL,NULL,NULL,'admin');
/*!40000 ALTER TABLE `staff_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-21  1:03:46
