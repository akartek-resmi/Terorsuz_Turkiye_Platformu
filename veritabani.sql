-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ttp_admin
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$IiGBj5LVvHn73uUuGtw2MeK0NOwEoJoGbTguGRwdhPF090E1isFaS','2026-09-10 22:20:48');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `board_members`
--

DROP TABLE IF EXISTS `board_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `org` varchar(150) DEFAULT '',
  `photo` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board_members`
--

LOCK TABLES `board_members` WRITE;
/*!40000 ALTER TABLE `board_members` DISABLE KEYS */;
INSERT INTO `board_members` VALUES (1,'Turgut LENK','Kurucu Genel Ba┼ƒkan','Ter├╢rs├╝z T├╝rkiye Platformu','wp-content/uploads/2026/03/turgut-lenk-e1774117152569.jpg',1);
/*!40000 ALTER TABLE `board_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `file` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instagram_posts`
--

DROP TABLE IF EXISTS `instagram_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instagram_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ig_id` varchar(64) DEFAULT NULL,
  `permalink` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `media_type` varchar(20) NOT NULL DEFAULT 'image',
  `posted_at` datetime DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_ig_id` (`ig_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instagram_posts`
--

LOCK TABLES `instagram_posts` WRITE;
/*!40000 ALTER TABLE `instagram_posts` DISABLE KEYS */;
INSERT INTO `instagram_posts` VALUES (1,'18203765434351755','https://www.instagram.com/reel/DY2LsV2tn8i/','wp-content/uploads/instagram/ig-18203765434351755.jpg','','video','2026-05-27 17:11:16',0),(2,'18348149287245678','https://www.instagram.com/reel/DYe7G31NjD1/','wp-content/uploads/instagram/ig-18348149287245678.jpg','','video','2026-05-18 16:22:19',1),(3,'18098420759030682','https://www.instagram.com/reel/DYZ6Z77tmgt/','wp-content/uploads/instagram/ig-18098420759030682.jpg','','video','2026-05-16 17:40:06',2),(4,'17924354283302603','https://www.instagram.com/p/DYVS2cpgOmd/','wp-content/uploads/instagram/ig-17924354283302603.jpg','','carousel','2026-05-14 22:36:55',3),(5,'18176922328393998','https://www.instagram.com/p/DXzFIn3AgdQ/','wp-content/uploads/instagram/ig-18176922328393998.jpg','','image','2026-05-01 15:42:54',4),(6,'17987171960979443','https://www.instagram.com/reel/DXtv6OWDbu4/','wp-content/uploads/instagram/ig-17987171960979443.jpg','','video','2026-04-29 14:06:30',5),(7,'18006924509853359','https://www.instagram.com/reel/DWcIFDhDfXF/','wp-content/uploads/instagram/ig-18006924509853359.jpg','','video','2026-03-28 20:15:05',6),(8,'18098008183961475','https://www.instagram.com/reel/DWcHaFYDWHh/','wp-content/uploads/instagram/ig-18098008183961475.jpg','','video','2026-03-28 20:09:15',7),(9,'17929085733231260','https://www.instagram.com/reel/DWFUP7lDWZX/','wp-content/uploads/instagram/ig-17929085733231260.jpg','','video','2026-03-19 23:40:01',8),(10,'17891114613309484','https://www.instagram.com/reel/DV3jIdzAhun/','wp-content/uploads/instagram/ig-17891114613309484.jpg','','video','2026-03-14 15:20:33',9),(11,'17961921279049303','https://www.instagram.com/p/DV3ZnR4gjp1/','wp-content/uploads/instagram/ig-17961921279049303.jpg','','image','2026-03-14 13:56:07',10),(12,'18077478941618698','https://www.instagram.com/p/DV3V3s4AlNy/','wp-content/uploads/instagram/ig-18077478941618698.jpg','','carousel','2026-03-14 13:23:18',11),(13,'17930253507054001','https://www.instagram.com/reel/DVoHT_rgmmx/','wp-content/uploads/instagram/ig-17930253507054001.jpg','','video','2026-03-08 15:31:45',12),(14,'18575103574004628','https://www.instagram.com/p/DVeYaImAH21/','wp-content/uploads/instagram/ig-18575103574004628.jpg','','image','2026-03-04 20:44:30',13),(15,'18118713496721080','https://www.instagram.com/reel/DVaP7L0Aoxv/','wp-content/uploads/instagram/ig-18118713496721080.jpg','','video','2026-03-03 06:13:29',14),(16,'18161399524424797','https://www.instagram.com/p/DVWu6qygAgb/','wp-content/uploads/instagram/ig-18161399524424797.jpg','','carousel','2026-03-01 21:27:14',15),(17,'18104701609657443','https://www.instagram.com/reel/DVL1sGfggmg/','wp-content/uploads/instagram/ig-18104701609657443.jpg','','video','2026-02-25 15:55:07',16),(18,'17957248280917206','https://www.instagram.com/p/DVLxiSyAhJz/','wp-content/uploads/instagram/ig-17957248280917206.jpg','','image','2026-02-25 15:18:33',17),(19,'18382634503084715','https://www.instagram.com/p/DVDXCPlAljB/','wp-content/uploads/instagram/ig-18382634503084715.jpg','','image','2026-02-22 08:53:04',18),(20,'18080504033521265','https://www.instagram.com/reel/DUyf-JbAGaq/','wp-content/uploads/instagram/ig-18080504033521265.jpg','','video','2026-02-15 19:44:39',19);
/*!40000 ALTER TABLE `instagram_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip_time` (`ip`,`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body_html` mediumtext NOT NULL,
  `cover_image` varchar(255) DEFAULT '',
  `published_at` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'ankarada-terorsuz-turkiyeye-evet','AnkaraΓÇÖda ΓÇ£Ter├╢rs├╝z T├╝rkiyeΓÇÖye EvetΓÇ¥','<p>Ter├╢rs├╝z T├╝rkiye Platformu\'nun Kurucu Genel Ba┼ƒkan─▒ Turgut Lenk, d├╝zenlenen ├╢zel bir programda yapt─▒─ƒ─▒ konu┼ƒmada, y├╝r├╝tt├╝kleri ├ºal─▒┼ƒman─▒n k─▒sa s├╝rede b├╝y├╝k bir kar┼ƒ─▒l─▒k buldu─ƒunu ve hedeflerinin her ge├ºen g├╝n daha da netle┼ƒti─ƒini ifade etti.</p>\n<p>Lenk, T├╝rkiye\'nin ter├╢rden ar─▒nd─▒r─▒lmas─▒ hedefinin art─▒k yaln─▒zca bir s├╢ylem de─ƒil, toplumun farkl─▒ kesimlerini bir araya getiren g├╝├ºl├╝ bir irade haline geldi─ƒini vurgulad─▒. Siyasi bir olu┼ƒumdan ba─ƒ─▒ms─▒z olarak hareket ettiklerini belirten Lenk, bu s├╝recin tamamen milletin ortak vicdan─▒, sivil toplumun g├╝c├╝ ve toplumsal dayan─▒┼ƒma ile ┼ƒekillendi─ƒini dile getirdi.</p>\n<p>Yakla┼ƒ─▒k sekiz ayd─▒r yo─ƒun bir emek verdiklerini s├╢yleyen Lenk, bu s├╝re zarf─▒nda ├╢nemli bir yol kat ettiklerini ve olu┼ƒturduklar─▒ yap─▒ ile art─▒k sahada daha g├╝├ºl├╝ bir ┼ƒekilde var olduklar─▒n─▒ belirtti. Kanaat ├╢nderleri, a┼ƒiret temsilcileri ve ├ºe┼ƒitli sivil olu┼ƒumlar─▒n s├╝rece aktif katk─▒ sundu─ƒunu ifade ederek, bu birlikteli─ƒin en b├╝y├╝k g├╝├ºleri oldu─ƒunu s├╢yledi.</p>\n<p>Belirlenen yol haritas─▒ do─ƒrultusunda ├ºal─▒┼ƒmalar─▒n─▒ kararl─▒l─▒kla s├╝rd├╝receklerini vurgulayan Lenk, T├╝rkiye\'nin d├╢rt bir yan─▒nda bu hedefi daha y├╝ksek sesle dile getireceklerini ve m├╝cadeleyi sonuna kadar s├╝rd├╝receklerini ifade etti.</p>\n<p>Programda, k├╝lt├╝rel birlikteli─ƒi ve ortak de─ƒerleri yans─▒tan ├╢zel g├╢sterimler de yer ald─▒. Kat─▒l─▒mc─▒lar, m├╝zik ve dans performanslar─▒yla duygusal anlar ya┼ƒarken, birlik ve beraberlik mesaj─▒ g├╝├ºl├╝ bir ┼ƒekilde hissedildi.</p>\n<p>Etkinli─ƒe kat─▒lan vak─▒f ve konfederasyon temsilcileri, kanaat ├╢nderleri ve b├╢lgesel liderler de yapt─▒klar─▒ konu┼ƒmalarda, ter├╢rle m├╝cadelede toplumsal dayan─▒┼ƒman─▒n vazge├ºilmez bir unsur oldu─ƒuna dikkat ├ºekerek, ortak hareket etmenin ├╢nemini vurgulad─▒.</p>','wp-content/uploads/2026/03/haber-bg-ankara.jpg','2026-03-28'),(2,'terorsuz-turkiye-platformu-genel-baskani-turgut-lenkten-81-ilde-birlik-ve-dayanisma-hamlesi','TER├ûRS├£Z T├£RK─░YE PLATFORMU GENEL BA┼₧KANI TURGUT LENKΓÇÖTEN 81 ─░LDE B─░RL─░K VE DAYANI┼₧MA HAMLES─░','<p>Kaynak: <a href=\"https://www.haberimgazete.com/2026/03/14/1465/\" target=\"_blank\" rel=\"noopener\">Haberimgazete.com</a></p>\n<p><strong>ANKARA</strong> ΓÇô Ter├╢rs├╝z T├╝rkiye Platformu, Ramazan ay─▒ dolay─▒s─▒yla Ankara\'n─▒n Ke├ºi├╢ren il├ºesinde d├╝zenledi─ƒi iftar program─▒nda sivil toplum kurulu┼ƒlar─▒, siyasi parti temsilcileri, sendika yetkilileri ve kanaat ├╢nderlerini bir araya getirdi. Programda, T├╝rkiye\'nin</p>\n<p><img src=\"/wp-content/uploads/2026/03/baskan-175x300.png\" alt=\"\" style=\"max-width:175px;float:right;margin-left:16px;\" /></p>\n<p>k, ΓÇ£Amac─▒m─▒z, milletimizin birli─ƒini ve devletimizin g├╝c├╝n├╝ desteklemek. Sivil toplum ├╢rg├╝tleri olarak birle┼ƒip ter├╢rs├╝z bir T├╝rkiye i├ºin ├ºal─▒┼ƒ─▒yoruz.ΓÇ¥ dedi.</p>\n<p>birli─ƒi, beraberli─ƒi ve ter├╢rs├╝z bir gelecek hedefi ├╢n plana ├º─▒kt─▒.</p>\n<p>Platformun Kurucu Genel Ba┼ƒkan─▒ <strong>Turgut Lenk</strong>, yapt─▒─ƒ─▒ konu┼ƒmada T├╝rkiye\'nin son 50 y─▒lda ya┼ƒad─▒─ƒ─▒ zorluklara dikkat ├ºekere</p>\n<p><strong>M─░LLET─░M─░Z─░N B─░RL─░─₧─░, DEVLET─░M─░Z─░N G├£C├£ ─░├ç─░N ├çALI┼₧IYORUZ</strong></p>\n<p>Lenk, Ter├╢rs├╝z T├╝rkiye Platformu\'nun Do─ƒu ve G├╝neydo─ƒu b├╢lgelerinde ya┼ƒanan sorunlara ├º├╢z├╝m ├╝retmek amac─▒yla kuruldu─ƒunu belirterek, a┼ƒiret liderleri, kanaat ├╢nderleri vak─▒flar, federasyonlar ve kamu temsilcilerinin deste─ƒiyle g├╝├ºl├╝ bir birliktelik olu┼ƒturduklar─▒n─▒ ifade etti.</p>\n<p><a href=\"https://www.haberimgazete.com/2026/03/14/1465/\" target=\"_blank\" rel=\"noopener\">Haberin devam─▒ i├ºin t─▒klay─▒n─▒z</a></p>','wp-content/uploads/2026/03/haber-bg-turkiye-birlik.jpg','2026-03-28');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region_coordinators`
--

DROP TABLE IF EXISTS `region_coordinators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region_coordinators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `photo` varchar(255) DEFAULT '',
  `certificate` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region_coordinators`
--

LOCK TABLES `region_coordinators` WRITE;
/*!40000 ALTER TABLE `region_coordinators` DISABLE KEYS */;
INSERT INTO `region_coordinators` VALUES (1,'Do─ƒu ve G├╝neydo─ƒu Sorumlusu','E┼ƒref Kemal SARAL','wp-content/uploads/2026/05/ESREF-KEMAL-SARAL-1.jpg','wp-content/uploads/2026/05/esref-kemal-saral.jpg',1);
/*!40000 ALTER TABLE `region_coordinators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representative_members`
--

DROP TABLE IF EXISTS `representative_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `representative_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate` varchar(2) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT '',
  `certificate` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_rm_plate` (`plate`),
  KEY `idx_rm_parent` (`parent_id`),
  CONSTRAINT `fk_rm_parent` FOREIGN KEY (`parent_id`) REFERENCES `representative_members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rm_plate` FOREIGN KEY (`plate`) REFERENCES `representatives` (`plate`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representative_members`
--

LOCK TABLES `representative_members` WRITE;
/*!40000 ALTER TABLE `representative_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `representative_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representatives`
--

DROP TABLE IF EXISTS `representatives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `representatives` (
  `plate` varchar(2) NOT NULL,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL DEFAULT 'ΓöÇΓûæl BaΓö╝╞ÆkanΓöÇΓûÆ',
  `photo` varchar(255) DEFAULT '',
  `certificate` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`plate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representatives`
--

LOCK TABLES `representatives` WRITE;
/*!40000 ALTER TABLE `representatives` DISABLE KEYS */;
INSERT INTO `representatives` VALUES ('02','Abdullah YAL├çIN','─░l Ba┼ƒkan─▒','wp-content/uploads/2026/04/ABDULLAH-YALCIN-ADIYAMAN-1.jpg','wp-content/uploads/2026/04/ABDULLAH-YALCIN-ADIYAMAN.jpg',1),('13','Cengiz ┼₧AH─░N','─░l Ba┼ƒkan─▒','','wp-content/uploads/2026/04/CENGIZ-SAHIN-BITLIS.jpg',2),('56','Mesut E┼₧─░N','─░l Ba┼ƒkan─▒','','wp-content/uploads/2026/04/MESUT-ESIN-SIIRT.jpg',3),('63','Mehmet ├ûZKAN','─░l Ba┼ƒkan─▒','','',4),('65','H├╝sn├╝ ART─░M','─░l Ba┼ƒkan─▒','wp-content/uploads/2026/04/HUSNU-ARTIM.jpg','wp-content/uploads/2026/04/HUSNU-ARTIM-VAN.jpg',5),('72','Mehmet Salih ├ûZT├£RK','─░l Ba┼ƒkan─▒','wp-content/uploads/2026/04/MEHMET-SALIH-OZTURK.jpg','wp-content/uploads/2026/04/MEHMET-SALIH-OZTURK-BATMAN.jpg',6),('73','Fevzi ├ûTER','─░l Ba┼ƒkan─▒','wp-content/uploads/2026/04/FEVZI-OTER.jpg','wp-content/uploads/2026/04/FEVZI-OTER-SIRNAK.jpg',7);
/*!40000 ALTER TABLE `representatives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` mediumtext DEFAULT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES ('contact_address',''),('contact_email',''),('contact_phone',''),('contact_whatsapp',''),('founder_message','<p>Aziz milletimizin k├╢kl├╝ birlik, beraberlik ve karde┼ƒlik ruhunu daha da peki┼ƒtirmek amac─▒yla, ├╝lkemizin yedi b├╢lgesinde kapsaml─▒ etkinlikler ger├ºekle┼ƒtirme kararl─▒l─▒─ƒ─▒yla yola ├º─▒km─▒┼ƒ bulunmaktay─▒z. Bu anlaml─▒ s├╝re├ºte, k─▒ymetli kanaat ├╢nderleri ve sivil toplum kurulu┼ƒlar─▒ (STK\'lar) ile g├╝├º birli─ƒi i├ºerisinde hareket ederek, devletimizin bekas─▒na ve milletimizin huzuruna katk─▒ sunmay─▒ en temel sorumlulu─ƒumuz olarak g├╢rmekteyiz.</p>\n<p>Ter├╢r├╝n her t├╝rl├╝s├╝n├╝ reddeden bir anlay─▒┼ƒla; g├╝venli, huzurlu ve ter├╢rs├╝z bir T├╝rkiye idealini ger├ºekle┼ƒtirmek ad─▒na devletimizin yan─▒nda dimdik durmay─▒ g├╢rev biliyoruz.</p>\n<p>Bu kutlu ve tarihi yolculukta, ├╝lkemizin d├╢rt bir yan─▒ndan gelecek desteklerin, ortak hedeflerimize ula┼ƒmam─▒zda en b├╝y├╝k g├╝├º kayna─ƒ─▒m─▒z olaca─ƒ─▒na inan─▒yoruz. Aziz milletimizin deste─ƒi ve dualar─▒yla, karde┼ƒli─ƒin h├ókim oldu─ƒu, bar─▒┼ƒ ve huzurun daim k─▒l─▒nd─▒─ƒ─▒ bir T├╝rkiye i├ºin azim ve kararl─▒l─▒kla y├╝r├╝meye devam edece─ƒiz.</p>'),('hakkimizda',''),('instagram_bio','Ter├╢rs├╝z T├╝rkiye Platformu, T├╝rkiyenin ortak akl─▒ ve m├╝┼ƒterek iradesiyle m├╝mk├╝nd├╝r. #ter├╢rs├╝zt├╝rkiye'),('instagram_last_sync','2026-09-14 11:28:12'),('instagram_profile_image','wp-content/uploads/2026/03/Terorsuz-Turkiye-2-copy.png'),('instagram_username','tcterorsuzturkiyeplatformu'),('misyon','<p>Ter├╢rs├╝z T├╝rkiye Platformu olarak misyonumuz; ├╝lkemizin b├╢l├╝nmez b├╝t├╝nl├╝─ƒ├╝n├╝, mill├« ve manevi de─ƒerlerini esas alarak toplumun her kesiminde birlik, beraberlik ve karde┼ƒlik bilincini g├╝├ºlendirmektir. Kanaat ├╢nderleri, sivil toplum kurulu┼ƒlar─▒ ve milletimizin t├╝m fertleriyle i┼ƒ birli─ƒi i├ºinde hareket ederek; adaletin, hukukun ve toplumsal huzurun h├ókim oldu─ƒu bir yap─▒n─▒n olu┼ƒmas─▒na katk─▒ sunmak temel amac─▒m─▒zd─▒r.</p>\n<p>Bu do─ƒrultuda; e─ƒitim, bilin├ºlendirme ve sosyal sorumluluk ├ºal─▒┼ƒmalar─▒n─▒n yan─▒ s─▒ra spor faaliyetleriyle gen├ºleri bir araya getirmeyi, toplumsal kayna┼ƒmay─▒ g├╝├ºlendirmeyi ve ├╢zellikle ┼ƒehit ailelerine y├╢nelik destek faaliyetleriyle vefa duygusunu canl─▒ tutmay─▒ g├╢rev bilmekteyiz.</p>'),('social_facebook',''),('social_instagram','https://www.instagram.com/tcterorsuzturkiyeplatformu/'),('social_linkedin',''),('social_twitter',''),('temel_degerler','├£lkemizi d├╝nya ├╝lkelerini i├ºinde en iyi ┼ƒekilde temsil etmek\n├£lkemizde hi├º bir ter├╢r unsurunun olmamas─▒ i├ºin ├ºaba sa─ƒlamak\n├£lkemizde farkl─▒ ─▒rk din dil meshep g├╢zetmeksizin karde┼ƒ├ºe ya┼ƒamak\n├£lkemizin kalk─▒nmas─▒ y├╢n├╝nde faaliyet g├╢sterip destek sa─ƒlamak\nTer├╢r├╝n hi├º bir faaliyetini ├╝lkemizde ya┼ƒanmamas─▒ i├ºin m├╝cadele etmek (kad─▒n ├ºocuk zehir taciri trafik yolsuzluk haks─▒zl─▒k adaletsizlik spor vs ter├╢r├╝) dur demek\n├£lkemizde her ilde karde┼ƒlik kul├╝pleri kurup gen├ºler ve gelece─ƒimiz i├ºin sosyal faaliyetler d├╝zenlemek\n├£lkemizde gen├ºler ile do─ƒu bat─▒ kuzey g├╝ney y├╢n├╝nde gezi d├╝zenleyip sosyal karde┼ƒlik pekistirmesi ne fayda sa─ƒlamak\nT├╝rkiyemizde herkesle karde┼ƒ├ºe ya┼ƒamak'),('tuzuk',''),('vizyon','<p>Ter├╢rs├╝z T├╝rkiye Platformu olarak vizyonumuz; mill├« birlik ve beraberli─ƒin en ├╝st seviyede ya┼ƒand─▒─ƒ─▒, adaletin ve hukukun ├╝st├╝nl├╝─ƒ├╝n├╝n tam anlam─▒yla tesis edildi─ƒi, her bireyin kendini g├╝vende ve ├╢zg├╝r hissetti─ƒi ter├╢rs├╝z bir T├╝rkiye\'nin olu┼ƒmas─▒na ├╢nc├╝l├╝k etmektir. Farkl─▒l─▒klar─▒n zenginlik olarak g├╢r├╝ld├╝─ƒ├╝, karde┼ƒli─ƒin ve dayan─▒┼ƒman─▒n toplumun temel de─ƒeri h├óline geldi─ƒi bir gelecek hedeflemekteyiz.</p>\n<p>Bu hedef do─ƒrultusunda; s├╝rd├╝r├╝lebilir sosyal projeler, g├╝├ºl├╝ i┼ƒ birlikleri ve toplumsal fark─▒ndal─▒k ├ºal─▒┼ƒmalar─▒yla yaln─▒zca bug├╝n├╝ de─ƒil, gelecek nesilleri de g├╝vence alt─▒na alan bir yap─▒ olu┼ƒturmay─▒ ama├ºl─▒yoruz.</p>');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ttp_admin'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-28 21:09:39
