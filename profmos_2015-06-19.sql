# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: delooff.synology.me (MySQL 5.5.42-MariaDB)
# Database: profmos
# Generation Time: 2015-06-19 09:54:17 +0000
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



# Dump of table perceel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `perceel`;

CREATE TABLE `perceel` (
  `PerceelID` int(11) NOT NULL AUTO_INCREMENT,
  `Plaats` varchar(45) NOT NULL,
  `Nummer` varchar(10) NOT NULL,
  PRIMARY KEY (`PerceelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
