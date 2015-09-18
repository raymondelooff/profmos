# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: delooff.synology.me (MySQL 5.5.43-MariaDB)
# Database: profmos
# Generation Time: 2015-09-18 12:46:53 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bedrijf
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bedrijf`;

CREATE TABLE `bedrijf` (
  `BedrijfID` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(45) NOT NULL,
  `Afkorting` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`BedrijfID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `bedrijf` WRITE;
/*!40000 ALTER TABLE `bedrijf` DISABLE KEYS */;

INSERT INTO `bedrijf` (`BedrijfID`, `Naam`, `Afkorting`)
VALUES
	(1,'Testbedrijf','TB'),
	(2,'test2','t2'),
	(3,'Test3','t3'),
	(4,'Hammes','HAMM'),
	(5,'234235','HMM'),
	(6,'OSWD','13242345'),
	(7,'Hammes','HAMM'),
	(8,'RvY','RvY'),
	(9,'Test bedrijf 1000','TB1000'),
	(10,'Test','test'),
	(11,'pitch bedrijf','PB');

/*!40000 ALTER TABLE `bedrijf` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table behandeling
# ------------------------------------------------------------

DROP TABLE IF EXISTS `behandeling`;

CREATE TABLE `behandeling` (
  `BehandelingID` int(11) NOT NULL AUTO_INCREMENT,
  `Datum` int(11) NOT NULL,
  `Activiteit` varchar(45) NOT NULL,
  `Mosselgroep_MosselgroepID` int(11) DEFAULT NULL,
  `Zaaiing_ZaaiingID` int(11) DEFAULT NULL,
  `Bedrijf_BedrijfID` int(11) NOT NULL,
  `Vak_VakID` int(11) NOT NULL,
  `Perceel_PerceelID` int(11) NOT NULL,
  `Opmerking` varchar(200) DEFAULT NULL,
  `Monster` tinyint(1) NOT NULL,
  `MonsterLabel` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`BehandelingID`),
  KEY `fk_behandeling_bedrijf1_idx` (`Bedrijf_BedrijfID`),
  KEY `fk_behandeling_vak1_idx` (`Vak_VakID`),
  KEY `fk_behandeling_perceel1_idx` (`Perceel_PerceelID`),
  KEY `fk_behandeling_zaaiing1_idx` (`Zaaiing_ZaaiingID`),
  KEY `Mosselgroep_MosselgroepID` (`Mosselgroep_MosselgroepID`),
  CONSTRAINT `fk_behandeling_bedrijf1` FOREIGN KEY (`Bedrijf_BedrijfID`) REFERENCES `bedrijf` (`BedrijfID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_behandeling_mosselgroep1` FOREIGN KEY (`Mosselgroep_MosselgroepID`) REFERENCES `mosselgroep` (`MosselgroepID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_behandeling_perceel1` FOREIGN KEY (`Perceel_PerceelID`) REFERENCES `perceel` (`PerceelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_behandeling_vak1` FOREIGN KEY (`Vak_VakID`) REFERENCES `vak` (`VakID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_behandeling_zaaiing1` FOREIGN KEY (`Zaaiing_ZaaiingID`) REFERENCES `zaaiing` (`ZaaiingID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `behandeling` WRITE;
/*!40000 ALTER TABLE `behandeling` DISABLE KEYS */;

INSERT INTO `behandeling` (`BehandelingID`, `Datum`, `Activiteit`, `Mosselgroep_MosselgroepID`, `Zaaiing_ZaaiingID`, `Bedrijf_BedrijfID`, `Vak_VakID`, `Perceel_PerceelID`, `Opmerking`, `Monster`, `MonsterLabel`)
VALUES
	(26,1434627826,'Sterren Dweilen',38,45,1,2,1,'Dit is een opmerking.',1,'Dit is een label'),
	(27,1681509600,'Trekje op perceel',NULL,NULL,8,14,23,'monster trekje perceel',1,'monster trekje perceel'),
	(28,1681509600,'Trekje op perceel',NULL,NULL,8,14,23,'monster trekje perceel',1,'monster trekje perceel'),
	(29,1681509600,'Trekje op perceel',NULL,NULL,8,14,23,'monster trekje perceel',1,'monster trekje perceel'),
	(30,1681509600,'Trekje op perceel',46,54,8,14,23,'monster trekje perceel',1,'monster trekje perceel'),
	(31,1465941600,'Sterren Dweilen',NULL,NULL,8,14,23,'Dit is weer een opmerking.',1,'monstertje'),
	(32,1465941600,'Sterren Rapen',NULL,NULL,8,14,23,'Dit is weer een opmerking.',1,'monstertje'),
	(33,1465941600,'Onder Zoet Water',NULL,NULL,8,14,23,'Dit is weer een opmerking.',1,'monstertje'),
	(34,1465941600,'Onder Warm Water',NULL,NULL,2,1,1,'Dit is weer een opmerking.',1,'monstertje'),
	(35,1465941600,'Peulen',NULL,NULL,2,8,18,'Dit is weer een opmerking.',1,'monstertje'),
	(36,1465941600,'Groen',NULL,NULL,4,7,17,'Dit is weer een opmerking.',1,'monstertje'),
	(37,1465941600,'Droog Leggen',NULL,NULL,2,4,3,'Dit is weer een opmerking.',1,'monstertje'),
	(38,1465941600,'Over Spoelerij',NULL,NULL,8,14,23,'Dit is weer een opmerking.',1,'monstertje');

/*!40000 ALTER TABLE `behandeling` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table boot
# ------------------------------------------------------------

DROP TABLE IF EXISTS `boot`;

CREATE TABLE `boot` (
  `BootID` int(11) NOT NULL AUTO_INCREMENT,
  `Bedrijf_BedrijfID` int(11) NOT NULL,
  `Naam` varchar(45) NOT NULL,
  PRIMARY KEY (`BootID`),
  KEY `fk_boot_bedrijf_idx` (`Bedrijf_BedrijfID`),
  CONSTRAINT `fk_boot_bedrijf` FOREIGN KEY (`Bedrijf_BedrijfID`) REFERENCES `bedrijf` (`BedrijfID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `boot` WRITE;
/*!40000 ALTER TABLE `boot` DISABLE KEYS */;

INSERT INTO `boot` (`BootID`, `Bedrijf_BedrijfID`, `Naam`)
VALUES
	(1,2,'bootje'),
	(2,2,'bootje2'),
	(3,2,'Fortuna'),
	(4,2,'222'),
	(5,2,'.'),
	(6,8,'YE116'),
	(7,9,'Test boot 1000'),
	(8,10,'Testboot'),
	(9,11,'pitch boot');

/*!40000 ALTER TABLE `boot` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table meting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meting`;

CREATE TABLE `meting` (
  `MetingID` int(11) NOT NULL AUTO_INCREMENT,
  `Vak_VakID` int(11) NOT NULL,
  `Perceel_PerceelID` int(11) NOT NULL,
  `Datum` int(11) NOT NULL,
  `Compartiment` int(11) NOT NULL,
  `Type` varchar(45) NOT NULL,
  `Lengte` float DEFAULT NULL,
  `Natgewicht` float DEFAULT NULL,
  `Visgewicht` float DEFAULT NULL,
  `AFDW` float DEFAULT NULL,
  `DW_Schelp` float DEFAULT NULL,
  PRIMARY KEY (`MetingID`),
  KEY `fk_meting_vak1_idx` (`Vak_VakID`),
  KEY `fk_meting_perceel1_idx` (`Perceel_PerceelID`),
  CONSTRAINT `fk_meting_perceel1` FOREIGN KEY (`Perceel_PerceelID`) REFERENCES `perceel` (`PerceelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meting_vak1` FOREIGN KEY (`Vak_VakID`) REFERENCES `vak` (`VakID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `meting` WRITE;
/*!40000 ALTER TABLE `meting` DISABLE KEYS */;

INSERT INTO `meting` (`MetingID`, `Vak_VakID`, `Perceel_PerceelID`, `Datum`, `Compartiment`, `Type`, `Lengte`, `Natgewicht`, `Visgewicht`, `AFDW`, `DW_Schelp`)
VALUES
	(5,1,1,1434492000,3,'Halfwas',0,2,2,1,1),
	(9,2,1,1433282400,1,'zaad',10,10,10,10,10),
	(11,8,18,1433289600,1,'consumptieFormaat',1,1,1,1,1),
	(12,8,18,1433289600,1,'consumptieFormaat',1,1,1,1,1),
	(13,8,18,1433282400,1,'consumptieFormaat',1,1,1,1,1),
	(14,8,18,1433282400,7,'Consumptie formaat',2,2,2,2,2),
	(15,2,1,1432677600,3,'Consumptie formaat',45,4576,53,764,876),
	(16,1,1,1434146400,4,'Consumptie formaat',20,30,40,50,60);

/*!40000 ALTER TABLE `meting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table monster
# ------------------------------------------------------------

DROP TABLE IF EXISTS `monster`;

CREATE TABLE `monster` (
  `MonsterID` int(11) NOT NULL AUTO_INCREMENT,
  `Bedrijf_BedrijfID` int(11) NOT NULL,
  `Boot_BootID` int(11) NOT NULL,
  `Perceel_PerceelID` int(11) NOT NULL,
  `Vak_VakID` int(11) NOT NULL,
  `mosselgroep_MosselgroepID` int(11) NOT NULL,
  `Datum` int(11) NOT NULL,
  `BrutoMonster` float DEFAULT NULL,
  `NettoMonster` float DEFAULT NULL,
  `Tarra` float DEFAULT NULL,
  `Busstal` int(11) DEFAULT NULL,
  `GewichtMossel` float DEFAULT NULL,
  `Slippers` float DEFAULT NULL,
  `Zeester` float DEFAULT NULL,
  `Pokken` float DEFAULT NULL,
  `BusNetto` float DEFAULT NULL,
  `AantalKookmonsters` int(11) DEFAULT NULL,
  `NettoKookmonster` float DEFAULT NULL,
  `VisTotaleMonster` float DEFAULT NULL,
  `VisPercentage` float DEFAULT NULL,
  `Stukstal` float DEFAULT NULL,
  `Kroesnr` int(11) DEFAULT NULL,
  `Kroes` float DEFAULT NULL,
  `KroesEnVlees` float DEFAULT NULL,
  `DW` float DEFAULT NULL,
  `AFDW` float DEFAULT NULL,
  `AFDWpM` float DEFAULT NULL,
  `SchelpenDroog` float DEFAULT NULL,
  `GemiddeldeLengte` float DEFAULT NULL,
  `GrGewicht` float DEFAULT NULL,
  `GrLengte` float DEFAULT NULL,
  `GrAFDW` float DEFAULT NULL,
  `Opmerking` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`MonsterID`),
  KEY `fk_monster_perceel1_idx` (`Perceel_PerceelID`),
  KEY `fk_monster_bedrijf1_idx` (`Bedrijf_BedrijfID`),
  KEY `fk_monster_boot1_idx` (`Boot_BootID`),
  KEY `fk_monster_vak1_idx` (`Vak_VakID`),
  KEY `fk_monster_mosselgroep1_idx` (`mosselgroep_MosselgroepID`),
  CONSTRAINT `fk_monster_bedrijf1` FOREIGN KEY (`Bedrijf_BedrijfID`) REFERENCES `bedrijf` (`BedrijfID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_monster_boot1` FOREIGN KEY (`Boot_BootID`) REFERENCES `boot` (`BootID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_monster_mosselgroep1` FOREIGN KEY (`mosselgroep_MosselgroepID`) REFERENCES `mosselgroep` (`MosselgroepID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_monster_perceel1` FOREIGN KEY (`Perceel_PerceelID`) REFERENCES `perceel` (`PerceelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_monster_vak1` FOREIGN KEY (`Vak_VakID`) REFERENCES `vak` (`VakID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `monster` WRITE;
/*!40000 ALTER TABLE `monster` DISABLE KEYS */;

INSERT INTO `monster` (`MonsterID`, `Bedrijf_BedrijfID`, `Boot_BootID`, `Perceel_PerceelID`, `Vak_VakID`, `mosselgroep_MosselgroepID`, `Datum`, `BrutoMonster`, `NettoMonster`, `Tarra`, `Busstal`, `GewichtMossel`, `Slippers`, `Zeester`, `Pokken`, `BusNetto`, `AantalKookmonsters`, `NettoKookmonster`, `VisTotaleMonster`, `VisPercentage`, `Stukstal`, `Kroesnr`, `Kroes`, `KroesEnVlees`, `DW`, `AFDW`, `AFDWpM`, `SchelpenDroog`, `GemiddeldeLengte`, `GrGewicht`, `GrLengte`, `GrAFDW`, `Opmerking`)
VALUES
	(21,8,6,23,14,1,1401746400,1081,1081,0,53,0,52,0,0,0,53,594,138,23,0,0,69,207,210,35,0.660377,24,50,NULL,NULL,NULL,'Geen'),
	(27,8,6,23,14,1,1407362400,1394.9,1379.7,0.0108968,0,0,0,0,0.2,0,50,575.2,135.844,23.6,0,0,2.1026,137.947,33.2356,30.5543,0.611086,204.7,51.26,0,0.0193846,-0.000758329,'Geen'),
	(29,8,6,18,8,9,1433887200,1,1,0,1,1,1,1,1,1,1,1,1,1,2500,1,1,1,1,1,1,1,1,NULL,NULL,NULL,'1'),
	(30,2,2,3,4,34,1433282400,64.87,123.12,-0.89795,19827,0.00131134,182.12,129,90,26,234,89,1238,33,1906440,87,98.124,898,981,76,0.324786,897,32.6,NULL,NULL,NULL,'Dit is een test opmerking.'),
	(38,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,NULL,NULL,NULL,'33'),
	(39,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,0,0,0,'33'),
	(40,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,0,0,0,'33'),
	(41,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,0,0,0,'33'),
	(42,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,0,0,0,'33'),
	(43,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,0,0,0,'33'),
	(44,8,6,21,11,45,1434232800,765,675,0.117647,675,1.44889,675,6756,5465,978,76,65,54,67,1725.46,53,4587,56,6,543,7.14474,7,564,-0.00000111111,0,-0.00000315789,'33'),
	(45,9,7,1,3,14,1433455200,4,4,0,54,1045.85,65675,6454,543,56476,67567,56,45,453,2.3904,64564564,5,433,545876,54,0.000799207,364,33457,NULL,NULL,NULL,'45678'),
	(46,9,7,25,17,43,1434146400,30,20,0.333333,10,2,30,30,20,20,30,20,10,20,1250,30,20,30,10,20,0.666667,10,30,NULL,NULL,NULL,'Dit is een opmerking');

/*!40000 ALTER TABLE `monster` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mosselgroep
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mosselgroep`;

CREATE TABLE `mosselgroep` (
  `MosselgroepID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentMosselgroepID` int(11) DEFAULT NULL,
  PRIMARY KEY (`MosselgroepID`),
  KEY `fk_mosselgroep_mosselgroep1_idx` (`ParentMosselgroepID`),
  CONSTRAINT `fk_mosselgroep_mosselgroep1` FOREIGN KEY (`ParentMosselgroepID`) REFERENCES `mosselgroep` (`MosselgroepID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `mosselgroep` WRITE;
/*!40000 ALTER TABLE `mosselgroep` DISABLE KEYS */;

INSERT INTO `mosselgroep` (`MosselgroepID`, `ParentMosselgroepID`)
VALUES
	(1,NULL),
	(11,NULL),
	(12,NULL),
	(13,NULL),
	(14,NULL),
	(15,NULL),
	(16,NULL),
	(17,NULL),
	(18,NULL),
	(19,NULL),
	(20,NULL),
	(21,NULL),
	(22,NULL),
	(23,NULL),
	(24,NULL),
	(25,NULL),
	(26,NULL),
	(27,NULL),
	(28,NULL),
	(29,NULL),
	(30,NULL),
	(31,NULL),
	(32,NULL),
	(33,NULL),
	(34,NULL),
	(35,NULL),
	(36,NULL),
	(37,NULL),
	(38,NULL),
	(39,NULL),
	(44,NULL),
	(45,NULL),
	(46,NULL),
	(47,NULL),
	(48,NULL),
	(49,NULL),
	(50,NULL),
	(51,NULL),
	(52,NULL),
	(53,NULL),
	(54,NULL),
	(55,NULL),
	(56,NULL),
	(57,NULL),
	(58,NULL),
	(59,NULL),
	(60,NULL),
	(61,NULL),
	(62,NULL),
	(63,NULL),
	(64,NULL),
	(65,NULL),
	(66,NULL),
	(67,NULL),
	(68,NULL),
	(69,NULL),
	(70,NULL),
	(71,NULL),
	(72,NULL),
	(73,NULL),
	(74,NULL),
	(75,NULL),
	(76,NULL),
	(80,NULL),
	(81,NULL),
	(82,NULL),
	(83,NULL),
	(84,NULL),
	(86,NULL),
	(2,1),
	(3,1),
	(4,1),
	(9,1),
	(10,1),
	(7,5),
	(5,9),
	(6,9),
	(8,31),
	(40,38),
	(41,38),
	(42,38),
	(43,38),
	(85,65),
	(77,74),
	(79,74),
	(78,76);

/*!40000 ALTER TABLE `mosselgroep` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oogst
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oogst`;

CREATE TABLE `oogst` (
  `OogstID` int(11) NOT NULL AUTO_INCREMENT,
  `Zaaiing_ZaaiingID` int(11) DEFAULT NULL,
  `Mosselgroep_MosselgroepID` int(11) DEFAULT NULL,
  `Activiteit` varchar(45) NOT NULL,
  `Datum` int(11) NOT NULL,
  `BrutoMton` int(11) DEFAULT NULL,
  `Kilogram` int(11) DEFAULT NULL,
  `Rendement` float DEFAULT NULL,
  `Stukstal` int(11) DEFAULT NULL,
  `Bustal` int(11) DEFAULT NULL,
  `Oppervlakte` float DEFAULT NULL,
  `Opmerking` varchar(200) DEFAULT NULL,
  `Monster` tinyint(1) NOT NULL,
  `MonsterLabel` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`OogstID`),
  KEY `fk_oogst_zaaiing1_idx` (`Zaaiing_ZaaiingID`),
  KEY `fk_oogst_mosselgroep1_idx` (`Mosselgroep_MosselgroepID`),
  CONSTRAINT `fk_oogst_mosselgroep1` FOREIGN KEY (`Mosselgroep_MosselgroepID`) REFERENCES `mosselgroep` (`MosselgroepID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oogst_zaaiing1` FOREIGN KEY (`Zaaiing_ZaaiingID`) REFERENCES `zaaiing` (`ZaaiingID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `oogst` WRITE;
/*!40000 ALTER TABLE `oogst` DISABLE KEYS */;

INSERT INTO `oogst` (`OogstID`, `Zaaiing_ZaaiingID`, `Mosselgroep_MosselgroepID`, `Activiteit`, `Datum`, `BrutoMton`, `Kilogram`, `Rendement`, `Stukstal`, `Bustal`, `Oppervlakte`, `Opmerking`, `Monster`, `MonsterLabel`)
VALUES
	(53,45,38,'Verzaaien',1434625167,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(54,45,38,'Verzaaien',1434625352,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(55,45,38,'Verzaaien',1434625414,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(56,46,38,'Verzaaien',1434625603,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(57,45,38,'Verzaaien',1434625664,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(58,46,43,'Verzaaien',1434625978,30,3000,NULL,30,20,NULL,'Dit is een opmerking.',1,'Dit is een label'),
	(59,NULL,NULL,'Verzaaien',1686693600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'monster'),
	(60,NULL,NULL,'Vissen voor veiling',1433368800,400,40000,NULL,300,200,NULL,'edrftgh',1,'hijhbhj'),
	(61,NULL,NULL,'Vissen voor veiling',1433368800,500,50000,NULL,300,200,NULL,'fegegsg',1,'fgsrhbe'),
	(62,NULL,NULL,'Vissen voor veiling',1433368800,500,50000,NULL,300,200,NULL,'fegegsg',1,'fgsrhbe'),
	(63,NULL,NULL,'Vissen voor veiling',1433368800,500,50000,NULL,300,200,NULL,'fegegsg',1,'fgsrhbe'),
	(64,NULL,NULL,'Vissen voor veiling',1433368800,500,50000,NULL,300,200,NULL,'fegegsg',1,'fgsrhbe'),
	(65,NULL,NULL,'Leegvissen',1433973600,400,40000,NULL,300,200,NULL,'sadsadas',1,'htrfnt'),
	(66,NULL,NULL,'Leegvissen',1433973600,400,40000,NULL,300,200,NULL,'sadsadas',1,'htrfnt'),
	(67,NULL,NULL,'Leegvissen',1433973600,400,40000,NULL,300,200,NULL,'sadsadas',1,'htrfnt'),
	(68,54,46,'Verzaaien',1686693600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'monster'),
	(69,NULL,NULL,'Vissen voor veiling',1465941600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'monstertje'),
	(70,NULL,NULL,'Vissen voor veiling',1434060000,100,10000,NULL,300,200,NULL,'sadasdas',1,'fhghnhhg'),
	(71,NULL,NULL,'Vissen voor veiling',1434060000,100,10000,NULL,300,200,NULL,'sadasdas',1,'fhghnhhg'),
	(72,NULL,NULL,'Vissen voor veiling',1434060000,100,10000,NULL,300,200,NULL,'sadasdas',1,'fhghnhhg'),
	(73,NULL,NULL,'Leegvissen',1465941600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'monstertje'),
	(74,72,65,'Vissen voor veiling',1434060000,100,10000,NULL,300,200,NULL,'sadasdas',1,'fhghnhhg'),
	(75,72,65,'Vissen voor veiling',1434060000,100,10000,NULL,300,200,NULL,'sadasdas',1,'fhghnhhg'),
	(76,51,43,'Leegvissen',1434146400,20,2000,NULL,20,20,NULL,'testerdetest',1,'testerdetest'),
	(77,NULL,NULL,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'sasagrgert',1,'Hallo'),
	(78,NULL,NULL,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'sasagrgert',1,'Hallo'),
	(79,NULL,NULL,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'sasagrgert',1,'Hallo'),
	(80,72,65,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'sasagrgert',1,'Hallo'),
	(81,NULL,NULL,'Verzaaien',1432764000,300,30000,NULL,100,200,NULL,'sfsegbvwcsd',1,'feh'),
	(82,NULL,NULL,'Verzaaien',1432764000,300,30000,NULL,100,200,NULL,'sfsegbvwcsd',1,'feh'),
	(83,81,79,'Verzaaien',1433973600,2,200,NULL,20,20,NULL,'Hallo',1,'5'),
	(84,NULL,NULL,'Verzaaien',1432764000,300,30000,NULL,100,200,NULL,'sfsegbvwcsd',1,'feh'),
	(85,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(86,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(87,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(88,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(89,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(90,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(91,NULL,NULL,'Verzaaien',1433455200,400,40000,NULL,300,200,NULL,'sadsafw',1,'egh5ty'),
	(92,NULL,NULL,'Verzaaien',1433282400,400,40000,NULL,300,200,NULL,'dwfegrhtjy',1,'dwfethjykulk'),
	(93,NULL,NULL,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'cefebegbbe',1,'rergt'),
	(94,76,69,'Verzaaien',1434146400,400,40000,NULL,300,200,NULL,'cefebegbbe',1,'rergt'),
	(95,NULL,NULL,'Verzaaien',1433455200,330,33000,NULL,300,300,NULL,'fejoenoenbe',1,'fefege'),
	(96,NULL,NULL,'Verzaaien',1433455200,330,33000,NULL,300,300,NULL,'fejoenoenbe',1,'fefege'),
	(97,76,69,'Verzaaien',1433455200,330,33000,NULL,300,300,NULL,'fejoenoenbe',1,'fefege'),
	(98,89,82,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(99,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(100,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(101,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(102,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(103,76,69,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(104,72,65,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(105,72,65,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(106,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(107,72,85,'Verzaaien',1433541600,400,40000,NULL,300,200,NULL,'dwfeggrhr',0,''),
	(108,NULL,NULL,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(109,79,72,'Verzaaien',861753600,400,40000,NULL,300,200,NULL,'Dit is weer een opmerking.',1,'Hallo'),
	(110,NULL,NULL,'Verzaaien',1434060000,400,40000,NULL,300,200,NULL,'Dit is een opmerking.',1,'Dit is een monster.'),
	(111,103,86,'Verzaaien',1434060000,400,40000,NULL,300,200,NULL,'Dit is een opmerking.',1,'Dit is een monster.');

/*!40000 ALTER TABLE `oogst` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table perceel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `perceel`;

CREATE TABLE `perceel` (
  `PerceelID` int(11) NOT NULL AUTO_INCREMENT,
  `Plaats` varchar(45) NOT NULL,
  `Nummer` varchar(10) NOT NULL,
  PRIMARY KEY (`PerceelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `perceel` WRITE;
/*!40000 ALTER TABLE `perceel` DISABLE KEYS */;

INSERT INTO `perceel` (`PerceelID`, `Plaats`, `Nummer`)
VALUES
	(1,'AAAA','1'),
	(2,'OSWD','109'),
	(3,'OSWD','200'),
	(5,'HAM','184'),
	(6,'Mastgat','22'),
	(7,'OSWD','15'),
	(8,'HAM','109'),
	(9,'HAM','105'),
	(10,'OSWD','101'),
	(11,'OSWD','100'),
	(12,'HAM','89'),
	(13,'B','2'),
	(14,'C','3'),
	(15,'E','5'),
	(16,'E','5'),
	(17,'Perceeltje','19'),
	(18,'Goes','2'),
	(19,'534534','26'),
	(20,'Goes','143543'),
	(21,'.','25'),
	(23,'HAMM','186'),
	(24,'Test perceel 1000','67'),
	(25,'Test perceel 1000','67'),
	(26,'OSWD','13');

/*!40000 ALTER TABLE `perceel` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vak
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vak`;

CREATE TABLE `vak` (
  `VakID` int(11) NOT NULL AUTO_INCREMENT,
  `Omschrijving` varchar(45) NOT NULL DEFAULT 'Geheel',
  `Oppervlakte` float NOT NULL,
  `Perceel_PerceelID` int(11) NOT NULL,
  PRIMARY KEY (`VakID`),
  KEY `fk_vak_perceel1_idx` (`Perceel_PerceelID`),
  CONSTRAINT `fk_vak_perceel1` FOREIGN KEY (`Perceel_PerceelID`) REFERENCES `perceel` (`PerceelID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `vak` WRITE;
/*!40000 ALTER TABLE `vak` DISABLE KEYS */;

INSERT INTO `vak` (`VakID`, `Omschrijving`, `Oppervlakte`, `Perceel_PerceelID`)
VALUES
	(1,'Vak',20,1),
	(2,'Geheel',30,1),
	(3,'geheel',40,1),
	(4,'geheel',50,3),
	(5,'Geheel',50,15),
	(6,'Geheel',50,16),
	(7,'Geheel',120,17),
	(8,'Geheel',1400,18),
	(9,'Geheel',2,19),
	(10,'Geheel',3123,20),
	(11,'Geheel',25,21),
	(12,'Maakt pudding',2,13),
	(14,'Geheel',50,23),
	(15,'Geheel',9798,24),
	(16,'Vak 1000',398,24),
	(17,'Geheel',987,25),
	(18,'Vak boven',9798,2),
	(19,'Geheel',50,26),
	(20,'boven',20,26);

/*!40000 ALTER TABLE `vak` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table zaaiing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `zaaiing`;

CREATE TABLE `zaaiing` (
  `ZaaiingID` int(11) NOT NULL AUTO_INCREMENT,
  `Bedrijf_BedrijfID` int(11) NOT NULL,
  `Vak_VakID` int(11) NOT NULL,
  `Perceel_PerceelID` int(11) NOT NULL,
  `Mosselgroep_MosselgroepID` int(11) DEFAULT NULL,
  `Activiteit` varchar(45) NOT NULL,
  `Datum` int(11) DEFAULT NULL,
  `BrutoMton` int(11) DEFAULT NULL,
  `Kilogram` int(11) DEFAULT NULL,
  `KilogramPerM2` float DEFAULT NULL,
  `Bustal` int(11) DEFAULT NULL,
  `Monster` tinyint(1) NOT NULL,
  `MonsterLabel` varchar(200) DEFAULT NULL,
  `Opmerking` varchar(200) NOT NULL,
  PRIMARY KEY (`ZaaiingID`),
  KEY `fk_zaaiing_bedrijf1_idx` (`Bedrijf_BedrijfID`),
  KEY `fk_zaaiing_vak1_idx` (`Vak_VakID`),
  KEY `fk_zaaiing_perceel1_idx` (`Perceel_PerceelID`),
  KEY `fk_zaaiing_mosselgroep1_idx` (`Mosselgroep_MosselgroepID`),
  CONSTRAINT `fk_zaaiing_bedrijf1` FOREIGN KEY (`Bedrijf_BedrijfID`) REFERENCES `bedrijf` (`BedrijfID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_zaaiing_mosselgroep1` FOREIGN KEY (`Mosselgroep_MosselgroepID`) REFERENCES `mosselgroep` (`MosselgroepID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_zaaiing_perceel1` FOREIGN KEY (`Perceel_PerceelID`) REFERENCES `perceel` (`PerceelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_zaaiing_vak1` FOREIGN KEY (`Vak_VakID`) REFERENCES `vak` (`VakID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `zaaiing` WRITE;
/*!40000 ALTER TABLE `zaaiing` DISABLE KEYS */;

INSERT INTO `zaaiing` (`ZaaiingID`, `Bedrijf_BedrijfID`, `Vak_VakID`, `Perceel_PerceelID`, `Mosselgroep_MosselgroepID`, `Activiteit`, `Datum`, `BrutoMton`, `Kilogram`, `KilogramPerM2`, `Bustal`, `Monster`, `MonsterLabel`, `Opmerking`)
VALUES
	(45,1,2,1,38,'Zaaien',1434625133,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(46,1,3,1,38,'Verzaaien',1434625167,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(47,1,3,1,38,'Verzaaien',1434625352,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(48,1,3,1,38,'Verzaaien',1434625414,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(49,1,3,1,38,'Verzaaien',1434625603,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(50,1,3,1,38,'Verzaaien',1434625664,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(51,1,2,1,43,'Verzaaien',1434625978,30,3000,0.006,20,1,'Dit is een label','Dit is een opmerking.'),
	(52,1,2,1,44,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(53,1,2,1,45,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(54,8,14,23,46,'Bijzaaien',0,400,40000,0.08,200,1,'monstertje','Dit is weer een opmerking.'),
	(55,1,2,1,47,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(56,1,2,1,48,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(57,1,3,1,49,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(58,1,2,1,50,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(59,1,2,1,51,'Zaaien',0,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(60,1,2,1,52,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(61,1,2,1,53,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(62,1,2,1,54,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(63,1,2,1,56,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(64,1,2,1,57,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(65,1,2,1,58,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(66,1,2,1,59,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(67,1,2,1,60,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(68,1,2,1,61,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(69,1,2,1,62,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(70,1,2,1,63,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(71,1,2,1,64,'Zaaien',1433973600,400,40000,0.08,200,1,'Hallo','Hallo daar.'),
	(72,1,1,1,65,'Zaaien',1433973600,400,40000,0.00917431,200,1,'Hallo','fsgeg'),
	(73,1,1,1,66,'Zaaien',1433973600,500,50000,0.0114679,200,1,'Hallo','fsgeg'),
	(74,1,2,1,67,'Zaaien',1433368800,500,50000,0.0153846,200,1,'fgsrhbe','fegegsg'),
	(75,1,2,1,68,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(76,1,1,1,69,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(77,1,2,1,43,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(78,8,14,23,71,'Bijzaaien',1465941600,400,40000,0.08,200,1,'monstertje','Dit is weer een opmerking.'),
	(79,1,1,1,72,'Zaaien',1434060000,100,10000,0.0178571,200,1,'fgrshndtm','eaffef'),
	(80,1,1,1,73,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(81,2,1,1,74,'Zaaien',1434664800,2,200,0.001,20,1,'4','Hallo'),
	(82,8,14,23,75,'Bijzaaien',1465941600,400,40000,0.08,200,1,'monstertje','Dit is weer een opmerking.'),
	(83,2,1,1,76,'Zaaien',1434664800,2,200,0.001,30,1,'5','Hallo'),
	(85,1,3,1,NULL,'Verzaaien',1433455200,330,33000,0.165,300,1,'fefege','fejoenoenbe'),
	(86,1,3,1,69,'Verzaaien',1433455200,330,33000,0.165,300,1,'fefege','fejoenoenbe'),
	(87,1,2,1,80,'Zaaien',1432504800,674,67400,0.00857506,876,1,'Blabla label','jlshd'),
	(88,1,2,1,81,'Zaaien',1432504800,674,67400,0.00857506,876,1,'Blabla label','jlshd'),
	(89,1,1,1,82,'Bijzaaien',1434060000,7997,799700,0.0891527,654,1,'asoihsdFIH;isdhf;','Opmerking isufdoidsuf'),
	(90,8,14,23,83,'Zaaien',1433973600,45,4500,0.00671642,45,1,'Labeltje','Geen'),
	(91,2,8,18,84,'Zaaien',1433887200,1,100,0.001,1,0,'','nope'),
	(93,1,3,1,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(94,1,3,1,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(95,1,3,1,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(96,1,3,1,69,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(97,1,2,1,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(98,1,1,1,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(99,1,15,24,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(100,1,16,24,85,'Verzaaien',1433541600,400,40000,0.0714286,200,0,'','dwfeggrhr'),
	(101,1,16,24,NULL,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(102,1,16,24,72,'Verzaaien',861753600,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(103,11,20,26,86,'Zaaien',861746400,400,40000,0.133333,200,1,'Hallo','Dit is weer een opmerking.'),
	(104,5,16,24,NULL,'Verzaaien',1434060000,400,40000,0.133333,200,1,'Dit is een monster.','Dit is een opmerking.');

/*!40000 ALTER TABLE `zaaiing` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
