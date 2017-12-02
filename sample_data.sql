-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: eeks
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounting`
--

DROP TABLE IF EXISTS `accounting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounting` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'needs a NULL INSERT, but should be CURRENT_TIMESTAMP with MySQL 5.6+',
  `date_last_changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value_date` date DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `gross_amount` decimal(11,2) DEFAULT NULL,
  `tax_rate` decimal(3,2) DEFAULT NULL,
  `account` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_supplier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posting_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_of_costs` int(4) unsigned DEFAULT NULL,
  `mode_of_employment` int(4) unsigned DEFAULT NULL,
  `scope` int(4) unsigned DEFAULT NULL,
  `project` int(4) unsigned DEFAULT NULL,
  `cat_01` int(4) unsigned DEFAULT NULL,
  `cat_02` int(4) unsigned DEFAULT NULL,
  `cat_03` int(4) unsigned DEFAULT NULL,
  `notes_01` text COLLATE utf8_unicode_ci,
  `notes_02` text COLLATE utf8_unicode_ci,
  `notes_03` text COLLATE utf8_unicode_ci,
  `notes_04` text COLLATE utf8_unicode_ci,
  `notes_05` text COLLATE utf8_unicode_ci,
  `file_01` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_02` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_03` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_reimbursement` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounting`
--

LOCK TABLES `accounting` WRITE;
/*!40000 ALTER TABLE `accounting` DISABLE KEYS */;
INSERT INTO `accounting` VALUES (1,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-06-15','2016-06-29',150.00,NULL,'Girokonto','16011','Barbara Baldrian',NULL,'Website-Erstellung Nachbesserungen',15,1,4,NULL,NULL,NULL,NULL,'in Raten überwiesen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(2,'2017-10-20 21:56:05','2017-11-29 11:53:22',NULL,'2016-06-29',1000.00,NULL,'Girokonto','17009','Max Mustermann',NULL,'Website-Erstellung',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(3,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-07-27','2016-06-29',350.00,NULL,'Girokonto','16011','Barbara Baldrian',NULL,'Website-Erstellung Nachbesserungen',15,1,4,NULL,NULL,NULL,NULL,'in Raten überwiesen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(4,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-08-21','2016-08-19',200.00,NULL,'Girokonto','16012','Computer und Medien e. V.',NULL,'Sommerferienkurse',15,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(5,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-05','2016-11-07',90.00,NULL,'Barkasse','16013','Felix Flattermann',NULL,'3h HTML-Einzelunterricht',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(6,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-25','2016-11-07',50.00,NULL,'Girokonto','16014','Stadt Leipzig, Justus-Jonas-Schule',NULL,'2h Tanz-Workshop (Projektwoche)',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(7,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-10','2016-11-07',250.00,NULL,'Girokonto','16015','Computer und Medien e. V.',NULL,'Herbstferienkurse',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(8,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-10-06','2016-10-02',180.00,NULL,'Girokonto','16016','Computer und Medien e. V.',NULL,'HTML-Kurse Aug-Sept 2016',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(9,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-02-01','2016-11-09',24.00,NULL,'Girokonto','16017','Moritz Moster',NULL,'1h HTML-Einzelunterricht',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(10,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-21','2016-11-18',450.00,NULL,'Girokonto','16018','Bernd Hölle',NULL,'Logo-Vektorisierung, Website-Änderungen',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(11,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-27','2016-12-01',100.00,NULL,'Barkasse','16019','Verein meiner Freunde e. V.',NULL,'Auftritt zur Weihnachtsfeier',15,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(12,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-12-05','2016-12-01',90.00,NULL,'Girokonto','16020','Computer und Medien e. V.',NULL,'HTML-Kurse Nov 2016',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(13,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-12-05','2016-12-01',300.00,NULL,'Girokonto','16021','Computer und Medien e. V.',NULL,'Projekttag (Planung und Durchführung)',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(14,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-01-16','2017-01-16',30.00,NULL,'Barkasse','17001','Verein meiner Freunde e. V.',NULL,'1h Tanz-Workshop',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(15,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-02-01','2017-01-25',24.00,NULL,'Girokonto','17002','Moritz Moster',NULL,'1h HTML-Einzelunterricht',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(16,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-03-04','2017-02-20',40.00,NULL,'Girokonto','17003','Bernd-Boxhorn-Schule',NULL,'2h Tanz-Workshop im Sportunterricht',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(17,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-02-23','2017-02-20',145.00,NULL,'Girokonto','17004','Computer und Medien e. V.',NULL,'Winterferienkurse',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(18,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-03-30','2017-03-15',150.00,NULL,'Girokonto','17005','Computer und Medien e. V.',NULL,'Workshop Projekttag Plakatgestaltung',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(19,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-12','2017-04-07',200.00,NULL,'Girokonto','17006','Computer und Medien e. V.',NULL,'Weiterbildung Wordpress',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(20,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-21','2017-04-02',300.00,NULL,'Girokonto','17007','Einhornladen',NULL,'Umzug d. Onlineshops auf neuen Server',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(21,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-08-30','2016-08-27',-6.44,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(22,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-09-29','2016-09-27',-6.43,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(23,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-10-31','2016-10-27',-6.63,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(24,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-29','2016-11-27',-6.82,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(25,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-12-29','2016-12-27',-6.92,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(26,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-01-31','2017-01-27',-6.77,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(27,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-03-06','2017-02-27',-6.85,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(28,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-03-29','2017-03-27',-6.67,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(29,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-05-02','2017-04-27',-6.64,NULL,'Girokonto',NULL,'Github',NULL,'Webhosting (7$)',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(30,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-01-08','2017-01-05',-36.19,NULL,'Girokonto',NULL,'Druckerei um die Ecke',NULL,'Flyer-Druck',5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(31,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-09-02','2016-08-22',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(32,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-10-04','2016-09-23',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(33,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-03','2016-10-25',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(34,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-12-05','2016-11-22',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(35,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-01-02','2016-12-21',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(36,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-02-03','2017-01-26',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(37,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-03-06','2017-03-01',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(38,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-03','2017-03-22',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(39,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-05-04','2017-04-25',-14.95,NULL,'Girokonto',NULL,'CO2 (Telekonika)',NULL,'Telefon, Internet (anteilig 50% v. 29,90 €)',9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(44,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-05-23','2017-05-10',24.00,NULL,'Girokonto','17008','Moritz Moster',NULL,'1h HTML-Einzelunterricht',15,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(45,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-12-02','2016-12-02',-35.99,NULL,'Barkasse',NULL,'Elektronikladen  E. Erbsmann',NULL,'SVGA-Kabel 10m',4,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(46,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-16','2016-11-15',-9.54,NULL,'Girokonto',NULL,'LABEL-Markt',NULL,'Deko-Klebeband',3,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(47,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-22','2016-11-15',-250.98,NULL,'Girokonto',NULL,'Engel-Musik GmbH',NULL,'portable Musikanlage',4,2,NULL,NULL,NULL,NULL,NULL,NULL,'10 Jahre, außer auf Akku',NULL,NULL,NULL,NULL,NULL,NULL,0),(49,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-02','2016-11-01',-55.99,NULL,'Girokonto',NULL,'Schumi Schuhmarkt',NULL,'Schuhe und Schuhpflege',22,1,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(50,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-08-16','2016-08-12',-19.99,NULL,'Girokonto',NULL,'LEBE-Markt',NULL,'Kochtopf',12,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(51,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-09-02','2016-09-01',-95.90,NULL,'Girokonto',NULL,'Elektronikmarkt El&Tron',NULL,'Staubsauger',12,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(52,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-01-20','2017-01-20',-6.99,NULL,'Barkasse',NULL,'LEBE-Markt',NULL,'Arbeitshandschuhe',22,1,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(53,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-06','2017-04-05',-16.99,NULL,'Girokonto',NULL,'LABEL-Markt',NULL,'Haartrockner',4,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(54,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-24','2017-04-24',-47.97,NULL,'Barkasse',NULL,'Opi-Baumarkt',NULL,'Verteilerdosen, Regal',12,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(55,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-04-24','2017-04-24',-8.99,NULL,'Barkasse',NULL,'LEBE-Markt',NULL,'Thermoskanne',12,2,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(56,'2017-10-20 21:56:05','2017-11-29 11:53:22',NULL,'2017-05-09',-37.98,0.00,'Girokonto',NULL,'Kleidungsladen',NULL,'Hemd, Krawatten',22,1,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(57,'2017-10-20 21:56:05','2017-11-29 11:53:22','2017-05-10','2017-05-09',-149.99,NULL,'Girokonto',NULL,'Haushaltswarenladen',NULL,'Spezial-Kaffeemaschine',12,2,NULL,NULL,NULL,NULL,NULL,NULL,'5 Jahre',NULL,NULL,NULL,NULL,NULL,NULL,0),(58,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-17',NULL,-23.42,NULL,'Girokonto',NULL,'lowcost-clothing (ebay)',NULL,'Glitzerunterwäsche',22,2,NULL,NULL,NULL,NULL,NULL,'keine Rechnung, nur E-Mail-Bestätigung',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(59,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-22',NULL,-5.19,NULL,'Girokonto',NULL,'lowqualitiy24 (ebay)',NULL,'USB-Maus',12,2,NULL,NULL,NULL,NULL,NULL,'keine Rechnung, nur E-Mail-Bestätigung',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(60,'2017-10-20 21:56:05','2017-11-29 11:53:22','2016-11-22','2016-11-22',-20.55,NULL,NULL,NULL,'Good Lack',NULL,'Farben',3,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(62,'2017-10-29 23:38:02','2017-11-29 11:53:22','2017-07-08','2017-07-30',200.00,NULL,'Girokonto',NULL,'Tanzende Kinder e. V.',NULL,'Trainingsangebote 2. Quartal 2017',17,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(63,'2017-10-29 23:38:13','2017-11-29 11:53:22','2017-04-05','2017-07-30',160.00,NULL,'Girokonto',NULL,'Tanzende Kinder e. V.',NULL,'Trainingsangebote 1. Quartal 2017',17,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(64,'2017-10-30 14:18:17','2017-11-29 11:53:22','2017-10-27','2017-10-22',-22.99,NULL,'Girokonto',NULL,'Einkaufsladen',NULL,'Druckerpapier, Stifte, Notizzettel, Ordner',2,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(65,'0000-00-00 00:00:00','2017-11-29 11:53:22','2017-08-14','2017-08-14',-40.00,NULL,'Barkasse',NULL,'Fort & Bildung gGmbH',NULL,'Seminar \"Phantasievoller Umgang mit HTML und CSS\"',13,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(66,'0000-00-00 00:00:00','2017-11-29 11:53:22','2017-09-10','2017-09-10',-40.00,NULL,'Barkasse',NULL,'Fort & Bildung gGmbH',NULL,'Seminar \"HTML und CSS sind keine Programmiersprachen\"',13,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(67,'0000-00-00 00:00:00','2017-11-29 11:56:18','2017-10-03','2017-10-02',-299.00,NULL,'Girokonto',NULL,'Elektronikfachmarkt',NULL,'Kettensäge',4,1,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,0),(68,'0000-00-00 00:00:00','2017-11-29 13:23:04','2017-10-11','2017-10-02',299.00,NULL,'Girokonto',NULL,'Elektronikfachmarkt',NULL,'Kettensäge',4,1,NULL,NULL,NULL,NULL,NULL,'Rückgabe wegen Fehlkaufs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(69,'0000-00-00 00:00:00','2017-11-29 14:16:53','2017-10-04','2017-10-02',-99.00,NULL,'Girokonto',NULL,'Druckerparadies24.com',NULL,'Toner für Drucker',2,1,NULL,NULL,NULL,NULL,NULL,NULL,'ja',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `accounting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coa_jobcenter_eks_01_2017`
--

DROP TABLE IF EXISTS `coa_jobcenter_eks_01_2017`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coa_jobcenter_eks_01_2017` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_costs` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `topic` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coa_jobcenter_eks_01_2017`
--

LOCK TABLES `coa_jobcenter_eks_01_2017` WRITE;
/*!40000 ALTER TABLE `coa_jobcenter_eks_01_2017` DISABLE KEYS */;
INSERT INTO `coa_jobcenter_eks_01_2017` VALUES (1,'A1 Betriebseinnahmen',NULL,3),(2,'A2 Privatentnahmen von Waren',NULL,3),(3,'A3 sonstige betriebliche Einnahmen',NULL,3),(4,'A4 Zuwendung von Dritten',NULL,3),(5,'A5 vereinnahmte Umsatzsteuer',NULL,3),(6,'A6 Umsatzsteuer auf Privatentnahmen von Waren',NULL,3),(7,'A7 vom Finanzamt erstattete Umsatzsteuer',NULL,3),(8,'B1 Wareneinkauf',NULL,4),(9,'B2 a) Vollzeitbeschäftigte','B2 Personalkosten (einschließlich Sozialversicherungsbeiträge)',4),(10,'B2 b) Teilzeitbeschäftigte','B2 Personalkosten (einschließlich Sozialversicherungsbeiträge)',4),(11,'B2 c) geringfügig Beschäftigte (450 Euro-Job)','B2 Personalkosten (einschließlich Sozialversicherungsbeiträge)',4),(12,'B2 d) mithelfende Familienangehörige','B2 Personalkosten (einschließlich Sozialversicherungsbeiträge)',4),(13,'B3 Raumkosten (einschließlich Nebenkosten und Energiekosten)',NULL,4),(14,'B4 betriebliche Versicherungen/ Beiträge ',NULL,4),(15,'B5.1 a) Steuern','B5 Kraftfahrzeugkosten\r\nB5.1 betriebliches Kraftfahrzeug',4),(16,'B5.1 b) Versicherung','B5 Kraftfahrzeugkosten\r\nB5.1 betriebliches Kraftfahrzeug',4),(17,'B5.1 c) laufende Betriebskosten','B5 Kraftfahrzeugkosten\r\nB5.1 betriebliches Kraftfahrzeug',4),(18,'B5.1 d) Reparaturen','B5 Kraftfahrzeugkosten\r\nB5.1 betriebliches Kraftfahrzeug',4),(19,'B5.2 privates Kraftfahrzeug - betriebliche Fahrten (0,10 Euro je gefahrenem km)','B5 Kraftfahrzeugkosten',4),(20,'B6 Werbung',NULL,4),(21,'B7 a) Übernachtungskosten','B7 Reisekosten',4),(22,'B7 b) Reisenebenkosten','B7 Reisekosten',4),(23,'B7 c) öffentliche Verkehrsmittel','B7 Reisekosten',4),(24,'B8 Investitionen',NULL,5),(25,'B9 Investitionen aus Zuwendungen Dritter',NULL,5),(26,'B10 Büromaterial einschließlich Porto',NULL,5),(27,'B11 Telefonkosten',NULL,5),(28,'B12 Beratungskosten',NULL,5),(29,'B13 Fortbildungskosten',NULL,5),(30,'B14 a) Reparatur Anlagevermögen','B14 sonstige Betriebsausgaben',5),(31,'B14 b) Miete Einrichtung','B14 sonstige Betriebsausgaben',5),(32,'B14 c) Nebenkosten des Geldverkehrs','B14 sonstige Betriebsausgaben',5),(33,'B14 d) betriebliche Abfallbeseitigung','B14 sonstige Betriebsausgaben',5),(34,'B14 e) Werkzeug, Arbeitsausrüstung','B14 sonstige Betriebsausgaben',5),(35,'B14 f) Werkstoffe, Arbeitsmaterial','B14 sonstige Betriebsausgaben',5),(36,'B14 g)','B14 sonstige Betriebsausgaben',5),(37,'B14 h)','B14 sonstige Betriebsausgaben',5),(38,'B14 i)','B14 sonstige Betriebsausgaben',5),(39,'B15 Schuldzinsen aus Anlagevermögen',NULL,5),(40,'B16 Tilgung bestehender betrieblicher Darlehen',NULL,5),(41,'B17 gezahlte Vorsteuer',NULL,5),(42,'B18 an das Finanzamt gezahlte Umsatzsteuer',NULL,5);
/*!40000 ALTER TABLE `coa_jobcenter_eks_01_2017` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mode_of_employment`
--

DROP TABLE IF EXISTS `mode_of_employment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mode_of_employment` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mode_of_employment` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(2) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mode_of_employment`
--

LOCK TABLES `mode_of_employment` WRITE;
/*!40000 ALTER TABLE `mode_of_employment` DISABLE KEYS */;
INSERT INTO `mode_of_employment` VALUES (1,'freiberuflich',1,''),(2,'privat',2,''),(3,'gewerblich',4,''),(4,'sozialversicherungspflichtig',6,''),(5,'kurzfristig',5,''),(6,'Aufwandsentschädigung',3,''),(7,'sonstiges/extern',7,'');
/*!40000 ALTER TABLE `mode_of_employment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(2) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scope`
--

DROP TABLE IF EXISTS `scope`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scope` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(2) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scope`
--

LOCK TABLES `scope` WRITE;
/*!40000 ALTER TABLE `scope` DISABLE KEYS */;
INSERT INTO `scope` VALUES (1,'Tanz/Performance/Show',NULL,NULL),(2,'Installation/Deko/Licht',NULL,NULL),(3,'Bildung/Workshops',NULL,NULL),(4,'Grafik/Webdesign',NULL,NULL),(5,'Ausstellung/Kunstverkauf',NULL,NULL),(6,'Sonstiges',NULL,NULL);
/*!40000 ALTER TABLE `scope` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_of_costs`
--

DROP TABLE IF EXISTS `type_of_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_costs` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_of_costs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_income` tinyint(1) DEFAULT NULL,
  `sort_order` int(2) unsigned DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coa_jobcenter_eks_01_2017` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_costs`
--

LOCK TABLES `type_of_costs` WRITE;
/*!40000 ALTER TABLE `type_of_costs` DISABLE KEYS */;
INSERT INTO `type_of_costs` VALUES (1,'noch nicht zugeordnet',NULL,NULL,NULL,0),(2,'Büro',NULL,NULL,NULL,26),(3,'Werkstoff',NULL,NULL,NULL,35),(4,'Werkzeug',NULL,NULL,NULL,34),(5,'Werbung',NULL,NULL,NULL,20),(6,'betriebl. Versicherungen',NULL,NULL,NULL,14),(7,'Raummiete',NULL,NULL,NULL,13),(8,'Kontogebühren',NULL,NULL,NULL,32),(9,'Telefon, Internet',NULL,NULL,NULL,27),(10,'Beratungskosten',NULL,NULL,NULL,28),(11,'Reise ÖPNV',NULL,NULL,NULL,23),(12,'Privatkram',NULL,NULL,NULL,0),(13,'Fortbildungskosten',NULL,NULL,NULL,13),(14,'Wareneinkauf',NULL,NULL,NULL,14),(15,'Honorar',1,1,NULL,1),(16,'Teilnahmebeiträge',1,2,NULL,1),(17,'Aufwandsentschädigung',1,4,NULL,0),(18,'Kunstverkauf',1,3,NULL,1),(19,'kurzfristig beschäftigt',1,5,NULL,0),(20,'Bewirtungskosten',NULL,NULL,NULL,20),(21,'Honorar (Ausgabe)',NULL,NULL,NULL,36),(22,'Arbeitskleidung',NULL,NULL,NULL,35),(23,'Gehalt',1,6,NULL,0);
/*!40000 ALTER TABLE `type_of_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'eeks'
--

--
-- Dumping routines for database 'eeks'
--

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-02 14:48:11
