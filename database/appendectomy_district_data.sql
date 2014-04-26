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
-- Table structure for table `district_data`
--

DROP TABLE IF EXISTS `district_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district_data` (
  `district_id` smallint(6) NOT NULL auto_increment,
  `district_name` varchar(30) NOT NULL,
  `district_legislator` varchar(20) NOT NULL,
  `party_name` varchar(30) NOT NULL,
  `zipcode` varchar(10) default NULL,
  `mailing_address` varchar(255) default NULL,
  `receiver` varchar(20) default NULL,
  `reason` text,
  `notice` text,
  `others` text,
  `prodescimgpath` varchar(255) default NULL,
  `petdescimgpath` varchar(255) default NULL,
  `prepaid` tinyint(1) default '0',
  `postoffice` varchar(30) default NULL,
  `adv_no` varchar(30) default NULL,
  `constituency` varchar(20) default NULL,
  PRIMARY KEY  (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district_data`
--

LOCK TABLES `district_data` WRITE;
/*!40000 ALTER TABLE `district_data` DISABLE KEYS */;
INSERT INTO `district_data` VALUES (1,'臺北市第01選區','丁守中','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,1'),(2,'臺北市第02選區','姚文智','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,2'),(3,'臺北市第03選區','羅淑蕾','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,3'),(4,'臺北市第04選區','蔡正元','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,4'),(5,'臺北市第05選區','林郁方','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,5'),(6,'臺北市第06選區','蔣乃辛','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,6'),(7,'臺北市第07選區','費鴻泰','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,7'),(8,'臺北市第08選區','賴士葆','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPE,8'),(9,'基隆市選區','謝國樑','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KEE,0'),(10,'新北市第01選區','吳育昇','中國國民黨','10699','台北郵局第117-380號信箱','馮光遠先生',NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',1,'台北','台北廣字第04599號','TPQ,1'),(11,'新北市第02選區','林淑芬','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,2'),(12,'新北市第03選區','高志鵬','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,3'),(13,'新北市第04選區','李鴻鈞','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,4'),(14,'新北市第05選區','黃志雄','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,5'),(15,'新北市第06選區','林鴻池','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,6'),(16,'新北市第07選區','江惠貞','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,7'),(17,'新北市第08選區','張慶忠','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,8'),(18,'新北市第09選區','林德福','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,9'),(19,'新北市第10選區','盧嘉辰','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,10'),(20,'新北市第11選區','羅明才','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,11'),(21,'新北市第12選區','李慶華','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TPQ,12'),(22,'宜蘭縣選區','陳歐珀','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'ILA,0'),(23,'桃園縣第01選區','陳根德','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,1'),(24,'桃園縣第02選區','廖正井','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,2'),(25,'桃園縣第03選區','陳學聖','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,3'),(26,'桃園縣第04選區','楊麗環','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,4'),(27,'桃園縣第05選區','呂玉玲','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,5'),(28,'桃園縣第06選區','孫大千','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TAO,6'),(29,'新竹市選區','呂學樟','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'HSZ,0'),(30,'新竹縣選區','徐欣瑩','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'HSQ,0'),(31,'苗栗縣第01選區','陳超明','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'MIA,1'),(32,'苗栗縣第02選區','徐耀昌','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'MIA,2'),(33,'臺中市第01選區','蔡其昌','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,1'),(34,'臺中市第02選區','顏寬恒','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,2'),(35,'臺中市第03選區','楊瓊瓔','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,3'),(36,'臺中市第04選區','蔡錦隆','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,4'),(37,'臺中市第05選區','盧秀燕','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,5'),(38,'臺中市第06選區','林佳龍','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,6'),(39,'臺中市第07選區','何欣純','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,7'),(40,'臺中市第08選區','江啟臣','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TXG,8'),(41,'彰化縣第01選區','王惠美','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CHA,1'),(42,'彰化縣第02選區','林滄敏','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CHA,2'),(43,'彰化縣第03選區','鄭汝芬','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CHA,3'),(44,'彰化縣第04選區','魏明谷','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CHA,4'),(45,'南投縣第01選區','馬文君','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'NAN,1'),(46,'南投縣第02選區','林明溱','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'NAN,2'),(47,'雲林縣第01選區','張嘉郡','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'YUN,1'),(48,'雲林縣第02選區','劉建國','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'YUN,2'),(49,'嘉義市選區','李俊俋','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CYI,0'),(50,'嘉義縣第01選區','翁重鈞','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CYQ,1'),(51,'嘉義縣第02選區','陳明文','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'CYQ,2'),(52,'臺南市第01選區','葉宜津','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TNN,1'),(53,'臺南市第02選區','黃偉哲','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TNN,2'),(54,'臺南市第03選區','陳亭妃','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TNN,3'),(55,'臺南市第04選區','許添財','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TNN,4'),(56,'臺南市第05選區','陳唐山','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TNN,5'),(57,'高雄市第01選區','邱議瑩','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,1'),(58,'高雄市第02選區','邱志偉','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,2'),(59,'高雄市第03選區','黃昭順','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,3'),(60,'高雄市第04選區','林岱樺','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,4'),(61,'高雄市第05選區','管碧玲','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,5'),(62,'高雄市第06選區','李昆澤','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,6'),(63,'高雄市第07選區','趙天麟','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,7'),(64,'高雄市第08選區','許智傑','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,8'),(65,'高雄市第09選區','林國正','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'KHH,9'),(66,'屏東縣第01選區','蘇震清','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'PIF,1'),(67,'屏東縣第02選區','王進士','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'PIF,2'),(68,'屏東縣第03選區','潘孟安','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'PIF,3'),(69,'臺東縣選區','劉櫂豪','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'TTT,0'),(70,'花蓮縣選區','王廷升','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'HUA,0'),(71,'澎湖縣選區','楊曜','民主進步黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'PEN,0'),(72,'金門縣選區','楊應雄','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'JME,0'),(73,'連江縣選區','陳雪生','無黨籍',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,'LJF,0'),(80,'平地原住民','廖國棟','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL),(81,'平地原住民','鄭天財','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL),(90,'山地原住民','孔文吉','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL),(91,'山地原住民','高金素梅','無黨團結聯盟',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL),(92,'山地原住民','簡東明','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL),(100,'僑居國外國民','詹凱臣','中國國民黨',NULL,NULL,NULL,NULL,NULL,NULL,'letter_explain_pro.jpg','letter_explain_pet.jpg',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `district_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-21  1:03:45
