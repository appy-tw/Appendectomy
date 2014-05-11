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
-- Table structure for table `doc_accept_spot`
--

DROP TABLE IF EXISTS `doc_accept_spot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_accept_spot` (
  `accept_spot_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `telephone` varchar(12) default NULL,
  `business_hour` varchar(255) NOT NULL,
  `city` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` text,
  `image_path` varchar(255) default NULL,
  `website_path` varchar(255) default NULL,
  `validation_code` varchar(50) NOT NULL,
  `checking_path` varchar(255) default NULL,
  PRIMARY KEY  (`accept_spot_id`),
  UNIQUE KEY `UNIQUE_NAME` (`name`,`city`,`district`,`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doc_accept_spot`
--

LOCK TABLES `doc_accept_spot` WRITE;
/*!40000 ALTER TABLE `doc_accept_spot` DISABLE KEYS */;
INSERT INTO `doc_accept_spot` VALUES (1,'海邊的卡夫卡‧藝文咖啡館','02-23641996','週日、週一 – 週四: 12:00 – 0:00\r\n週五 – 週六: 12:00 – 2:00','臺北市','中正區','羅斯福路三段244巷2號2樓','（捷運台電大樓／公館站，位於˙台電大樓旁）',NULL,'http://kafkabythe.blogspot.tw/','9864512341','http://www.uisltsc.com.tw/appendectomy/accept_spot_v.php&VC=9864512341'),(2,'測試','123','789','台中','中區','我家','123456',NULL,'123456','373700510328421979458087155580','http://www.uisltsc.com.tw/appendectomy/accept_spot_v.php&VC=373700510328421979458087155580');
/*!40000 ALTER TABLE `doc_accept_spot` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-11 13:02:18
