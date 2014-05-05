-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: scutoj
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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

CREATE DATABASE scutoj;

USE scutoj;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compile_info`
--

DROP TABLE IF EXISTS `compile_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compile_info` (
  `solutionId` int(11) NOT NULL,
  `error` text,
  PRIMARY KEY (`solutionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compile_info`
--

LOCK TABLES `compile_info` WRITE;
/*!40000 ALTER TABLE `compile_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `compile_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contest`
--

DROP TABLE IF EXISTS `contest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contest` (
  `contestId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT '',
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `defunct` tinyint(4) NOT NULL DEFAULT '0',
  `description` text,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `programLan` tinyint(4) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`contestId`),
  KEY `userId` (`userId`),
  CONSTRAINT `contest_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contest`
--

LOCK TABLES `contest` WRITE;
/*!40000 ALTER TABLE `contest` DISABLE KEYS */;
/*!40000 ALTER TABLE `contest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contest_problem`
--

DROP TABLE IF EXISTS `contest_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contest_problem` (
  `problemId` int(11) NOT NULL,
  `contestId` int(11) NOT NULL,
  `num` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`contestId`,`problemId`),
  KEY `problemId` (`problemId`),
  CONSTRAINT `contest_problem_ibfk_2` FOREIGN KEY (`contestId`) REFERENCES `contest` (`contestId`) ON DELETE CASCADE,
  CONSTRAINT `contest_problem_ibfk_1` FOREIGN KEY (`problemId`) REFERENCES `problem` (`problemId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contest_problem`
--

LOCK TABLES `contest_problem` WRITE;
/*!40000 ALTER TABLE `contest_problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `contest_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `courseId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `defunct` tinyint(3) NOT NULL DEFAULT '0',
  `private` tinyint(3) NOT NULL,
  `programLan` tinyint(4) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`courseId`),
  KEY `userId` (`userId`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_unit`
--

DROP TABLE IF EXISTS `course_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_unit` (
  `unitId` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  PRIMARY KEY (`unitId`,`courseId`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `course_unit_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `course` (`courseId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_unit`
--

LOCK TABLES `course_unit` WRITE;
/*!40000 ALTER TABLE `course_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_input`
--

DROP TABLE IF EXISTS `custom_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_input` (
  `solutionId` int(11) NOT NULL DEFAULT '0',
  `inputText` text,
  PRIMARY KEY (`solutionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_input`
--

LOCK TABLES `custom_input` WRITE;
/*!40000 ALTER TABLE `custom_input` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_input` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_log` (
  `info` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `result` tinyint(2) DEFAULT NULL,
  KEY `info_idx` (`info`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_log`
--

LOCK TABLES `login_log` WRITE;
/*!40000 ALTER TABLE `login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `newsId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `cotent` text NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `defunct` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`newsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privilege_common`
--

DROP TABLE IF EXISTS `privilege_common`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privilege_common` (
  `userId` int(11) NOT NULL,
  `commonId` int(11) NOT NULL,
  `common` varchar(15) NOT NULL,
  `privilege` varchar(20) NOT NULL,
  KEY `pri_idx` (`userId`,`commonId`,`common`),
  CONSTRAINT `privilege_common_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilege_common`
--

LOCK TABLES `privilege_common` WRITE;
/*!40000 ALTER TABLE `privilege_common` DISABLE KEYS */;
/*!40000 ALTER TABLE `privilege_common` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem`
--

DROP TABLE IF EXISTS `problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problem` (
  `problemId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `input` text,
  `output` text,
  `sampleInput` text,
  `sampleOutput` text,
  `hint` text,
  `source` varchar(200) DEFAULT NULL,
  `inDate` datetime DEFAULT NULL,
  `timeLimit` int(11) NOT NULL,
  `memoryLimit` int(11) NOT NULL,
  `defunct` tinyint(4) NOT NULL DEFAULT '0',
  `accepted` int(11) NOT NULL DEFAULT '0',
  `submit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`problemId`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem`
--

LOCK TABLES `problem` WRITE;
/*!40000 ALTER TABLE `problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `runtime_info`
--

DROP TABLE IF EXISTS `runtime_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `runtime_info` (
  `solutiondId` int(11) NOT NULL DEFAULT '0',
  `error` text,
  PRIMARY KEY (`solutiondId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `runtime_info`
--

LOCK TABLES `runtime_info` WRITE;
/*!40000 ALTER TABLE `runtime_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `runtime_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim`
--

DROP TABLE IF EXISTS `sim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sim` (
  `solutionId` int(11) NOT NULL,
  `simSolutionId` int(11) NOT NULL,
  `sim` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim`
--

LOCK TABLES `sim` WRITE;
/*!40000 ALTER TABLE `sim` DISABLE KEYS */;
/*!40000 ALTER TABLE `sim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solution`
--

DROP TABLE IF EXISTS `solution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solution` (
  `solutionId` int(11) NOT NULL AUTO_INCREMENT,
  `problemId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `runTime` int(11) NOT NULL,
  `memory` int(11) NOT NULL,
  `inDate` datetime DEFAULT NULL,
  `result` smallint(6) NOT NULL,
  `programLan` int(11) DEFAULT NULL,
  `contestId` int(11) DEFAULT NULL,
  `unitId` int(11) DEFAULT NULL,
  `valid` tinyint(4) DEFAULT NULL,
  `judgeTime` datetime DEFAULT NULL,
  `codeLen` int(11) DEFAULT NULL,
  PRIMARY KEY (`solutionId`),
  KEY `userId_id` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solution`
--

LOCK TABLES `solution` WRITE;
/*!40000 ALTER TABLE `solution` DISABLE KEYS */;
/*!40000 ALTER TABLE `solution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solution_code`
--

DROP TABLE IF EXISTS `solution_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solution_code` (
  `solutionId` int(11) NOT NULL,
  `code` text,
  PRIMARY KEY (`solutionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solution_code`
--

LOCK TABLES `solution_code` WRITE;
/*!40000 ALTER TABLE `solution_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `solution_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_problem`
--

DROP TABLE IF EXISTS `unit_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_problem` (
  `unitId` int(11) NOT NULL,
  `problemId` int(11) NOT NULL,
  PRIMARY KEY (`unitId`,`problemId`),
  KEY `problemId` (`problemId`),
  CONSTRAINT `unit_problem_ibfk_2` FOREIGN KEY (`problemId`) REFERENCES `problem` (`problemId`) ON DELETE CASCADE,
  CONSTRAINT `unit_problem_ibfk_1` FOREIGN KEY (`unitId`) REFERENCES `course_unit` (`unitId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_problem`
--

LOCK TABLES `unit_problem` WRITE;
/*!40000 ALTER TABLE `unit_problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `unit_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `programLan` tinyint(4) DEFAULT '0',
  `language` varchar(20) DEFAULT NULL,
  `regTime` datetime DEFAULT NULL,
  `nick` varchar(50) DEFAULT NULL,
  `school` varchar(50) DEFAULT NULL,
  `defunct` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_state`
--

DROP TABLE IF EXISTS `user_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_state` (
  `userId` int(11) NOT NULL,
  `accessTime` datetime DEFAULT NULL,
  `submit` int(11) DEFAULT '0',
  `solved` int(11) DEFAULT '0',
  PRIMARY KEY (`userId`),
  CONSTRAINT `user_state_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_state`
--

LOCK TABLES `user_state` WRITE;
/*!40000 ALTER TABLE `user_state` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_state` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-04  0:11:12
