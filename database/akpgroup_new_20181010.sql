-- MySQL dump 10.13  Distrib 5.5.59, for Win64 (AMD64)
--
-- Host: localhost    Database: akpgroup_new
-- ------------------------------------------------------
-- Server version	5.5.59

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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE_TIME` date NOT NULL,
  `TYPE` set('CHECK-IN','CHECK-OUT','TEMP-OUT','TEMP-IN') DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `EMPLOYEE_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_attendance_employee1_idx` (`EMPLOYEE_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'Ravi Perera','Kandy','0812736746','ravi@yahoo.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(2,'Prasad Gunasinghe','Colombo','0117387489','prasad@yahoo.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(3,'Nuwan kularahna','Colombo','0771828288','nuwan@gmail.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(4,'Nalin prasad','Gampaha','0117387389','sarath@yahoo.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(5,'Sarath silva','Gampaha','0117837488','sarath@gmail.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(7,'Anil kelum','Galle','0118273845','anil@yahoo.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(8,'Gayan silva','Colombo','0118273827','gayan@gmail.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(9,'Kapila gurusinghe','Galle','0118273867','kapila@yahoo.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1),(10,'Mala perera','Puttlam','0337262882','mala@gmail.com','2018-07-30 23:41:26',1,'2018-07-30 23:41:26',1,1);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_contact_person`
--

DROP TABLE IF EXISTS `client_contact_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_contact_person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_client_contact_person_client1_idx` (`CLIENT_ID`),
  CONSTRAINT `fk_client_contact_person_client1` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_contact_person`
--

LOCK TABLES `client_contact_person` WRITE;
/*!40000 ALTER TABLE `client_contact_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_contact_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_phone`
--

DROP TABLE IF EXISTS `client_phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_phone` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NUMBER` varchar(20) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_client_phone_client_idx` (`CLIENT_ID`),
  CONSTRAINT `fk_client_phone_client` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_phone`
--

LOCK TABLES `client_phone` WRITE;
/*!40000 ALTER TABLE `client_phone` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designation` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designation`
--

LOCK TABLES `designation` WRITE;
/*!40000 ALTER TABLE `designation` DISABLE KEYS */;
INSERT INTO `designation` VALUES (1,'Site Engineer','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(2,'Operator','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(3,'Welder','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(4,'Helper','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(5,'Driver','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(6,'Mechanic','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(7,'Electrician','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(8,'Labour','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(10,'Officer','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(11,'Supervisor','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(12,'Technical Officer','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(13,'operator1','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1),(14,'operator','2018-09-23 07:33:31',2,'2018-09-23 07:33:31',2,1);
/*!40000 ALTER TABLE `designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SERIAL_NO` varchar(255) DEFAULT NULL,
  `FULL_NAME` text,
  `NAME_WITH_INITIALS` varchar(255) NOT NULL,
  `PREFFERED_NAME` varchar(255) NOT NULL,
  `EPF_NO` varchar(100) DEFAULT NULL,
  `APPOINTMENT_DATE` date DEFAULT NULL,
  `NIC` varchar(15) NOT NULL,
  `DATE_OF_BIRTH` date DEFAULT NULL,
  `ADDRESS` text NOT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `PHOTO` blob,
  `BASIC_SALARY` decimal(13,2) DEFAULT NULL,
  `WORK_TARGET` decimal(13,2) DEFAULT NULL,
  `SP_INTENCIVE` decimal(13,2) DEFAULT NULL,
  `DIFFICULTY` decimal(13,2) DEFAULT NULL,
  `OTHER` decimal(13,2) DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `DESIGNATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_employee_designation1_idx` (`DESIGNATION_ID`),
  CONSTRAINT `fk_employee_designation1` FOREIGN KEY (`DESIGNATION_ID`) REFERENCES `designation` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'E0001','Chamilka Jayarathna','Chamilka Jayarathna','Chamilka','0001','2018-09-01','820000000V','2018-09-08','Mawanella','','addPhoto.png',20000.00,1.00,0.00,0.00,0.00,'2018-09-30 16:31:46',1,'2018-09-30 16:31:46',1,1,2);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine`
--

DROP TABLE IF EXISTS `machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine` (
  `ID` int(11) NOT NULL,
  `CODE` varchar(200) DEFAULT NULL,
  `NAME` text NOT NULL,
  `MODEL` text NOT NULL,
  `ENGINE_MODEL` text,
  `ENGINE_SERIAL` text,
  `CHASSIS_SERIAL` text,
  `YEAR` year(4) DEFAULT NULL,
  `DETAILS` text,
  `HP` int(10) DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `MACHINE_BRAND_ID` int(11) DEFAULT NULL,
  `MACHINE_CATEGORY_ID` int(11) DEFAULT NULL,
  `EMPLOYEE_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_machine_machine_brand1_idx` (`MACHINE_BRAND_ID`),
  KEY `fk_machine_machine_category1_idx` (`MACHINE_CATEGORY_ID`),
  KEY `fk_machine_employee1_idx` (`EMPLOYEE_ID`),
  CONSTRAINT `fk_machine_employee1` FOREIGN KEY (`EMPLOYEE_ID`) REFERENCES `employee` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_machine_machine_brand1` FOREIGN KEY (`MACHINE_BRAND_ID`) REFERENCES `machine_brand` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_machine_machine_category1` FOREIGN KEY (`MACHINE_CATEGORY_ID`) REFERENCES `machine_category` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine`
--

LOCK TABLES `machine` WRITE;
/*!40000 ALTER TABLE `machine` DISABLE KEYS */;
INSERT INTO `machine` VALUES (1,'AKP/WS/M/WP/C.1/005','S/ water pump \'03','NK Z-3-03','3\'\'','B10330286','7EJ00RT',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(2,'AKP/WS/M/WP/C.2/002','Ele water pump No-02','SXD1441.5','1\'\'','015966','7EJ00324',1992,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(3,'AKP/WS/M/WP/C.2/005','Ele water pump No-03','NK Z-3-03','','130363591','7EJ0SD',1998,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(4,'AKP/WS/M/WP/C.2/006','Ele water pump No-04','GX 160','D/2','130363811','7EJ00RE4',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(5,'AKP/WS/M/WP/C.3/001','Water pump 3\"','GX 160','','G6028896640','SEJ00424',1992,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(6,'AKP/WS/M/WP/C.3/004','Water pump 1\'\' ','','','08D1037774','7EJE0424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(7,'AKP/WS/M/WP/C.3/005','Water pump 3\"','NK Z-3-03','3\'\'','2420560','7EJ004243',1998,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(8,'AKP/WS/M/WP/C.3/006','Water pump 2\"','GX 160','','1208236','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(9,'AKP/WS/M/PO/C.1/001','Poker No-01','GX 160','3\'\'','3112922','7EJ00424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(10,'AKP/WS/M/PO/C.1/003','Poker No-03','NK Z-3-03','D/2','C387447','7TG00424',1998,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(11,'AKP/WS/M/PO/C.1/004','Poker No-04 ','GX 160','D/2','Z0103112928','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(12,'AKP/WS/M/PO/C.1/005','Poker No-05','','','8113907','7EJ00424',1992,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(13,'AKP/WS/M/PO/C.1/007','PetrolVibrator ','GX160','3\'\'','2912478','7EJ5T424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(14,'AKP/WS/M/PO/C.1/008','PetrolVibrator ','GX160','','2954651','',1992,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(15,'AKP/WS/M/PO/C.1/009','Petrol Vibrator','GX160','D/2','2928546','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(16,'AKP/WS/M/PO/C.1/010','Petrol Vibrator','GX 160','','2954646','7EJ00424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(17,'AKP/WS/M/PO/C.1/011','Petrol Vibrator','ZNR50','','168F12011767','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(18,'AKP/WS/M/PO/C.1/012','Diesel Vibrator','ZNR50','3\'\'','52416054','',1998,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(19,'AKP/WS/M/COM/C.1/001','Denyo 185 compressor','DPS180','D/2','SSB23633990','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(20,'AKP/WS/M/COM/C.1/003','PDS-125 compressor-03','(Mr.Nalaka)','','','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(21,'AKP/WS/M/COM/C.1/008','PDS 125  Compressor','S/type','3\'\'','06367','95529',1992,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(22,'AKP/WS/M/COM/C.1/009','PDR-125','NK Z-3-03','','S 31091','123707',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(23,'AKP/WS/K/BL/C.1/007','Portable compressor-2','E-610E','D/3','U632505F','7EJ00424',2001,'',700,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(24,'AKP/WS/M/COM/C.1/012','Double tunk air compressor','NK Z-3-03','D/2','1326941','ERF00424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(25,'AKP/WS/M/WPL/C.1/001','Power genaretors-  Red','DCI 2708S','','DC Engine Driven','RJ00424',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(26,'AKP/WS/M/VIB/C.1/001','Plate vibreters (1)','','','','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(27,'AKP/WS/D/BL/C.1/003','Plate vibreters (2)','GX 160','D/2','2410179','D 8007140',1998,'',150,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(28,'AKP/WS/M/VIB/C.1/002','Wacker Nuson(T/rammer-1)','NK Z-3-03','','1109684','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(29,'AKP/WS/Y/BL/C.1/002','Wacker Nuson (T/rammer-2)','E-610E','D/2','2110470','3CX4320581PS',2005,'',400,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(30,'AKP/WS/D/BL/C.1/004','Wacker Honda Maikasa-4','E-610E\n','D/4','9610056','3CX4320581PS',2001,'',300,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(31,'AKP/WS/M/VIB/C.1/004','Wacker Subaru -5','','','2338911','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(32,'AKP/WS/J/BL/C.1/004','Wacker Subaru -6','GX100','D/8','2338909','CE 3077 V',2001,'',150,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(33,'AKP/WS/M/VIB/C.1/005','Tamping Rammers-7','CJ60','','2538779CJ','',0000,'',NULL,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(34,'AKP/WS/R/BL/C.1/033','Tamping Rammers-8','CJ70','D/9','2478161','3CX4320581PS',2005,'',150,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL),(35,'AKP/WS/F/BL/C.1/005','Tamping Rammers -9','CJ80','S 4KE','2161208','CE 3077 V',2001,'',300,'2018-09-23 07:46:06',2,'2018-09-23 07:46:06',2,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `machine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_brand`
--

DROP TABLE IF EXISTS `machine_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_brand` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` text NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_brand`
--

LOCK TABLES `machine_brand` WRITE;
/*!40000 ALTER TABLE `machine_brand` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_category`
--

DROP TABLE IF EXISTS `machine_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_category` (
  `ID` int(11) NOT NULL,
  `NAME` text NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_category`
--

LOCK TABLES `machine_category` WRITE;
/*!40000 ALTER TABLE `machine_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_part`
--

DROP TABLE IF EXISTS `machine_part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_part` (
  `ID` int(11) NOT NULL,
  `NAME` text,
  `SERIAL_NO` varchar(255) DEFAULT NULL,
  `PRICE` double(10,2) DEFAULT NULL,
  `MAKE` varchar(255) DEFAULT NULL,
  `MODEL` varchar(255) DEFAULT NULL,
  `MANUFACTURE` text,
  `DESCRIPTION` text,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `MACHINE_PART_CATEGORY_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_machine_part_machine_part_category1_idx` (`MACHINE_PART_CATEGORY_ID`),
  CONSTRAINT `fk_machine_part_machine_part_category1` FOREIGN KEY (`MACHINE_PART_CATEGORY_ID`) REFERENCES `machine_part_category` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_part`
--

LOCK TABLES `machine_part` WRITE;
/*!40000 ALTER TABLE `machine_part` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_part` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_part_category`
--

DROP TABLE IF EXISTS `machine_part_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_part_category` (
  `ID` int(11) NOT NULL,
  `NAME` text,
  `DESCRIPTION` text,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_part_category`
--

LOCK TABLES `machine_part_category` WRITE;
/*!40000 ALTER TABLE `machine_part_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_part_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_repair`
--

DROP TABLE IF EXISTS `machine_repair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_repair` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` date NOT NULL,
  `MILEAGE` double(6,1) DEFAULT NULL,
  `COST` double(9,2) DEFAULT NULL,
  `DESCRIPTION` text,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `MACHINE_ID` int(11) NOT NULL,
  `MACHINE_REPAIR_TYPE_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_machine_service_machine1_idx` (`MACHINE_ID`),
  KEY `fk_machine_repair_machine_repair_type1_idx` (`MACHINE_REPAIR_TYPE_ID`),
  CONSTRAINT `fk_machine_repair_machine_repair_type1` FOREIGN KEY (`MACHINE_REPAIR_TYPE_ID`) REFERENCES `machine_repair_type` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_machine_service_machine10` FOREIGN KEY (`MACHINE_ID`) REFERENCES `machine` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_repair`
--

LOCK TABLES `machine_repair` WRITE;
/*!40000 ALTER TABLE `machine_repair` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_repair` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_repair_part`
--

DROP TABLE IF EXISTS `machine_repair_part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_repair_part` (
  `MACHINE_REPAIR_ID` int(11) NOT NULL,
  `MACHINE_REPAIR_PART_ID` int(11) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`MACHINE_REPAIR_ID`,`MACHINE_REPAIR_PART_ID`),
  KEY `fk_machine_repair_has_machine_part_machine_part1_idx` (`MACHINE_REPAIR_PART_ID`),
  KEY `fk_machine_repair_has_machine_part_machine_repair1_idx` (`MACHINE_REPAIR_ID`),
  CONSTRAINT `fk_machine_repair_has_machine_part_machine_part1` FOREIGN KEY (`MACHINE_REPAIR_PART_ID`) REFERENCES `machine_part` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_machine_repair_has_machine_part_machine_repair1` FOREIGN KEY (`MACHINE_REPAIR_ID`) REFERENCES `machine_repair` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_repair_part`
--

LOCK TABLES `machine_repair_part` WRITE;
/*!40000 ALTER TABLE `machine_repair_part` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_repair_part` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_repair_type`
--

DROP TABLE IF EXISTS `machine_repair_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_repair_type` (
  `ID` int(11) NOT NULL,
  `NAME` text,
  `DESCRIPTION` text,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_repair_type`
--

LOCK TABLES `machine_repair_type` WRITE;
/*!40000 ALTER TABLE `machine_repair_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_repair_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_service`
--

DROP TABLE IF EXISTS `machine_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_service` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DATE` date NOT NULL,
  `LAST_SERVICE_DATE` date DEFAULT NULL,
  `NEXT_SERVICE_DATE` date DEFAULT NULL,
  `MILEAGE` double(6,1) DEFAULT NULL,
  `COST` double(9,2) DEFAULT NULL,
  `DESCRIPTION` text,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `MACHINE_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_machine_service_machine1_idx` (`MACHINE_ID`),
  CONSTRAINT `fk_machine_service_machine1` FOREIGN KEY (`MACHINE_ID`) REFERENCES `machine` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_service`
--

LOCK TABLES `machine_service` WRITE;
/*!40000 ALTER TABLE `machine_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_service_part`
--

DROP TABLE IF EXISTS `machine_service_part`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_service_part` (
  `MACHINE_PART_ID` int(11) NOT NULL,
  `MACHINE_SERVICE_ID` int(11) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`MACHINE_PART_ID`,`MACHINE_SERVICE_ID`),
  KEY `fk_machine_part_has_machine_service_machine_service1_idx` (`MACHINE_SERVICE_ID`),
  KEY `fk_machine_part_has_machine_service_machine_part1_idx` (`MACHINE_PART_ID`),
  CONSTRAINT `fk_machine_part_has_machine_service_machine_part1` FOREIGN KEY (`MACHINE_PART_ID`) REFERENCES `machine_part` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_machine_part_has_machine_service_machine_service1` FOREIGN KEY (`MACHINE_SERVICE_ID`) REFERENCES `machine_service` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_service_part`
--

LOCK TABLES `machine_service_part` WRITE;
/*!40000 ALTER TABLE `machine_service_part` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_service_part` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `machine_site`
--

DROP TABLE IF EXISTS `machine_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `machine_site` (
  `SITE_ID` int(11) NOT NULL,
  `MACHINE_ID` int(11) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SITE_ID`,`MACHINE_ID`),
  KEY `fk_site_has_machine_machine1_idx` (`MACHINE_ID`),
  KEY `fk_site_has_machine_site1_idx` (`SITE_ID`),
  CONSTRAINT `fk_site_has_machine_machine1` FOREIGN KEY (`MACHINE_ID`) REFERENCES `machine` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_site_has_machine_site1` FOREIGN KEY (`SITE_ID`) REFERENCES `site` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `machine_site`
--

LOCK TABLES `machine_site` WRITE;
/*!40000 ALTER TABLE `machine_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `machine_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTRACT_NO` varchar(30) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `PROGRESS` varchar(100) NOT NULL,
  `COMMENCEMENT_DATE` date NOT NULL,
  `COMPLETION_DATE` date NOT NULL,
  `EXTENDED_DATE` date NOT NULL,
  `CONTRACT_PERIOD` int(11) NOT NULL,
  `CONTRACT_SUM` decimal(14,2) NOT NULL,
  `EXTENDED_CONTRACT_SUM` decimal(14,2) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_project_client1_idx` (`CLIENT_ID`),
  CONSTRAINT `fk_project_client1` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (2,'pro001','Kandy Building Construction','OnGoing','2018-10-11','2019-01-31','2018-10-18',90,1000000.00,100000.00,'2018-10-10 02:15:27',1,'2018-10-10 02:48:47',1,1,1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `contractNo` varchar(30) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `client` varchar(100) NOT NULL,
  `progress` varchar(100) NOT NULL,
  `commencementDate` date NOT NULL,
  `completionDate` date NOT NULL,
  `extendedDate` date NOT NULL,
  `contractPeriod` int(11) NOT NULL,
  `contractSum` decimal(11,0) NOT NULL,
  `extendedContractSum` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES ('001','Kandy','1','OnGoing','2017-11-07','2017-11-08','2017-11-07',3,50000,60000),('002','Mahawa','1','OnGoing','0000-00-00','0000-00-00','0000-00-00',2,40000,55000),('003','Badulla','1','OnGoing','0000-00-00','2017-11-16','2017-11-26',3,35000,45000),('004','Walimada','1','OnGoing','0000-00-00','0000-00-00','0000-00-00',5,45000,55000),('005','Kandy','1','OnGoing','0000-00-00','2017-11-09','2017-11-24',2,30000,35000),('006','Kandy','1','OnGoing','2017-11-28','2017-11-23','2017-11-07',6,55000,65000),('007','Walimada','','OnGoing','2017-11-21','2017-11-13','2017-11-07',4,60000,70000);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site`
--

DROP TABLE IF EXISTS `site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `LONGITUDE` decimal(10,6) DEFAULT NULL,
  `LATITUDE` decimal(10,6) DEFAULT NULL,
  `PROGRESS` int(2) DEFAULT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  `PROJECT_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_site_project1_idx` (`PROJECT_ID`),
  CONSTRAINT `fk_site_project1` FOREIGN KEY (`PROJECT_ID`) REFERENCES `project` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site`
--

LOCK TABLES `site` WRITE;
/*!40000 ALTER TABLE `site` DISABLE KEYS */;
/*!40000 ALTER TABLE `site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `USER_LEVEL` tinyint(1) NOT NULL,
  `INSERT_DATETIME` datetime DEFAULT NULL,
  `INSERT_USER` int(11) DEFAULT NULL,
  `UPDATE_DATETIME` datetime DEFAULT NULL,
  `UPDATE_USER` int(11) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user1','95c946bf622ef93b0a211cd0fd028dfdfcf7e39e',2,'2018-09-20 10:11:35',2,'2018-09-20 10:11:35',2,1),(2,'admin','7b902e6ff1db9f560443f2048974fd7d386975b0',1,'2018-09-20 12:56:05',2,'2018-09-20 12:56:05',2,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-10  9:12:05
