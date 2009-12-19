/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


DROP DATABASE IF EXISTS `smail`;
CREATE DATABASE `smail` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `smail`;
CREATE TABLE `account` (
  `id` varchar(25) NOT NULL default '',
  `password` varchar(40) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;

INSERT INTO `account` VALUES ('test','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');
INSERT INTO `account` VALUES ('tester','ab4d8d2a5f480a137067da17100271cd176607a1');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;
CREATE TABLE `group` (
  `id` varchar(25) NOT NULL default '',
  `readInvs` tinyint(3) unsigned NOT NULL default '0',
  `writeInvs` tinyint(3) unsigned NOT NULL default '0',
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;

INSERT INTO `group` VALUES ('neue Gruppe',0,0,'test');
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;
CREATE TABLE `membership` (
  `group` varchar(25) NOT NULL default '',
  `account` varchar(25) NOT NULL default '',
  `level` char(1) NOT NULL default 'r',
  PRIMARY KEY  (`group`,`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;

INSERT INTO `membership` VALUES ('neue Gruppe','session1','w');
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
