# ************************************************************
# Sequel Ace SQL dump
# Version 20094
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 5.7.34)
# Database: attendance_system
# Generation Time: 2025-08-17 16:48:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attendance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) DEFAULT NULL,
  `attendance_id` varchar(100) DEFAULT NULL,
  `clock_in` timestamp NULL DEFAULT NULL,
  `clock_out` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;

INSERT INTO `attendance` (`id`, `employee_id`, `attendance_id`, `clock_in`, `clock_out`, `created_at`, `updated_at`)
VALUES
	(6,'K00002','e5eb8685-5f63-4a33-8102-9e601d076574','2025-08-17 08:38:00','2025-08-17 16:32:00','2025-08-17 23:31:59','2025-08-17 23:45:11'),
	(7,'K00001','5daf099d-6153-4145-9a68-2e682a8dbdcb','2025-08-17 08:39:00','2025-08-17 17:54:00','2025-08-17 23:32:10','2025-08-17 23:44:59');

/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table attendance_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendance_history`;

CREATE TABLE `attendance_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) DEFAULT NULL,
  `attendance_id` varchar(100) DEFAULT NULL,
  `date_attendance` timestamp NULL DEFAULT NULL,
  `attendance_type` tinyint(1) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `attendance_history` WRITE;
/*!40000 ALTER TABLE `attendance_history` DISABLE KEYS */;

INSERT INTO `attendance_history` (`id`, `employee_id`, `attendance_id`, `date_attendance`, `attendance_type`, `description`, `created_at`, `updated_at`)
VALUES
	(6,'K00002','e5eb8685-5f63-4a33-8102-9e601d076574','2025-08-17 08:38:00',1,NULL,'2025-08-17 23:31:59','2025-08-17 23:31:59'),
	(7,'K00001','5daf099d-6153-4145-9a68-2e682a8dbdcb','2025-08-17 07:29:00',1,NULL,'2025-08-17 23:32:10','2025-08-17 23:32:10');

/*!40000 ALTER TABLE `attendance_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table departement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `departement`;

CREATE TABLE `departement` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `departement_name` varchar(255) DEFAULT NULL,
  `max_clock_in_time` time DEFAULT NULL,
  `max_clock_out_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `departement` WRITE;
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;

INSERT INTO `departement` (`id`, `departement_name`, `max_clock_in_time`, `max_clock_out_time`)
VALUES
	(1,'HR','08:30:00','17:30:00'),
	(2,'IT','09:00:00','17:30:00');

/*!40000 ALTER TABLE `departement` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) DEFAULT NULL,
  `departement_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;

INSERT INTO `employee` (`id`, `employee_id`, `departement_id`, `name`, `address`, `created_at`, `updated_at`)
VALUES
	(1,'K00001',1,'Yuyu','Serang, Banten','2025-08-17 20:35:41','2025-08-17 20:45:10'),
	(4,'K00002',2,'Ahmad','Jl Raya Labuan KM 23 Cikaliung Saketi Pandeglang','2025-08-17 20:44:56','2025-08-17 20:45:20');

/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
