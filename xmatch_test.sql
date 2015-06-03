-- MySQL dump 10.13  Distrib 5.5.40-36.1, for Linux (x86_64)
--
-- Host: localhost    Database: xmatchge_test
-- ------------------------------------------------------
-- Server version	5.5.40-36.1-log

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
-- Table structure for table `file_audit`
--

DROP TABLE IF EXISTS `file_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_audit` (
  `FileName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `FilePath` varchar(100) CHARACTER SET utf8 NOT NULL,
  `TimeLoaded` datetime NOT NULL,
  `TimeProcess` datetime NOT NULL,
  `NumberOfRecords` int(5) NOT NULL,
  `RunStatus` varchar(20) CHARACTER SET utf8 NOT NULL,
  `User` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_audit`
--

LOCK TABLES `file_audit` WRITE;
/*!40000 ALTER TABLE `file_audit` DISABLE KEYS */;
INSERT INTO `file_audit` VALUES ('users.csv','uploads/','2014-12-04 00:52:25','2014-12-15 06:48:01',0,'Run','Avi'),('Linux.txt','uploads/','2014-12-03 12:23:40','2014-12-15 06:48:01',0,'Run','Avi'),('columns_trim.txt','uploads/','2014-12-04 07:36:30','2014-12-15 06:48:01',0,'Run','Avi'),('cow.jpg','uploads/','2014-12-10 07:51:39','2014-12-15 06:48:01',0,'Run','yoni'),('cow.jpg','uploads/','2014-12-10 08:04:08','2014-12-15 06:48:01',0,'Run',''),('jacob.txt','uploads/','2014-12-14 05:09:55','2014-12-15 06:48:01',0,'Run','yoni'),('monday.txt','uploads/','2014-12-14 05:21:48','2014-12-15 06:48:01',0,'Run','yoni'),('nomi.txt','uploads/','2014-12-14 05:08:48','2014-12-15 06:48:01',0,'Run','yoni'),('bye.txt','uploads/','2014-12-14 05:05:12','2014-12-15 06:48:01',0,'Run','yoni');
/*!40000 ALTER TABLE `file_audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `type` varchar(50) CHARACTER SET utf16 NOT NULL,
  `lang` char(2) NOT NULL,
  `message` varchar(250) CHARACTER SET utf16 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=hebrew;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES ('Login','en','Login'),('Login','he','שם משתמש'),('password','en','Password'),('password','he','סיסמה');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supported_languages`
--

DROP TABLE IF EXISTS `supported_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supported_languages` (
  `Lang` char(2) NOT NULL DEFAULT 'EN',
  `Description` varchar(50) CHARACTER SET hebrew NOT NULL,
  `Allignment` char(3) NOT NULL DEFAULT 'L2R',
  UNIQUE KEY `Lang` (`Lang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Holds supported languages ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supported_languages`
--

LOCK TABLES `supported_languages` WRITE;
/*!40000 ALTER TABLE `supported_languages` DISABLE KEYS */;
INSERT INTO `supported_languages` VALUES ('EN','English','L2R'),('HE','עברית ','R2L');
/*!40000 ALTER TABLE `supported_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_details`
--

DROP TABLE IF EXISTS `users_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_details` (
  `User_Name` varchar(50) CHARACTER SET hebrew NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `User_type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `User_E_Mail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `User_Address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Date_joined` datetime NOT NULL,
  `Farm` varchar(50) CHARACTER SET utf8 NOT NULL,
  `User_First_Name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `User_Last_Name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Language` char(2) CHARACTER SET utf8 NOT NULL,
  `Farm_location` point NOT NULL,
  `Country` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Last_Location` point NOT NULL,
  `Distrbuter_User_Id` int(11) NOT NULL,
  `Genetic_protocol` varchar(10) CHARACTER SET utf8 NOT NULL,
  `TNC_accepted` char(1) CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  PRIMARY KEY (`User_Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_details`
--

LOCK TABLES `users_details` WRITE;
/*!40000 ALTER TABLE `users_details` DISABLE KEYS */;
INSERT INTO `users_details` VALUES ('Avi ','123456','Admin','avi@gmail.com ','Rubin 36 ','2014-09-01 00:00:00','prairie farm ','Avraham ','Cohen ','Fr','\0\0\0\0\0\0\0\0\0\0\0\0\0�?\0\0\0\0\0\0@','France','\0\0\0\0\0\0\0\0\0\0\0\0\0�?\0\0\0\0\0\0\"@',1,'','Y'),('yoni','123123','ContryDist','yo@gmail.com','hapisga 23','2014-10-06 00:00:00','Milky Way Farm','yonatan','levi','he','\0\0\0\0\0\0\0\0\0\0\0\0\0@\0\0\0\0\0\0@','israel','\0\0\0\0\0\0\0\0\0\0\0\0\0@@\0\0\0\0\0\0@',2,'','Y'),('aviel','258258','','aviel@gmail.com',' bayit vegan','2012-12-12 00:00:00','margalit','','','','','','',0,'','Y'),('','','','',' ','0000-00-00 00:00:00','','','','','','','',0,'','N'),('jacob','789789','FarmManager','jac@gmail.com',' beer yakob','2010-10-10 00:00:00','Animal Farm','','','','','','',0,'','N'),('yossi','753573','Enduser','yos@gmail.com',' har nof','2010-12-14 00:00:00','farm','','','','','','',0,'','N'),('nom','789654','ContryDist','naomy5359@gmail.com',' bayit vegan','2014-12-08 08:03:03','farmily','','','','','','',0,'','N'),('eric','987654','FarmManager','eric@gmail.com',' Ramot','2014-12-09 08:07:56','ramfarm','','','','','France','',0,'','N'),('rami','maganoya0p','FarmManager','rami.flam@gmail.com',' 741 Grant Rd.','2014-12-10 07:55:17','12345','','','','','','',0,'','N'),('daniel','741741','RegionalDist','dan@gmail.com',' rubin','2014-12-11 01:16:21','faf123','','','','','','',0,'','N');
/*!40000 ALTER TABLE `users_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-04  1:19:14
