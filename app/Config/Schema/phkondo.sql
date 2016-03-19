-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: phkondo
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `balcony` varchar(50) NOT NULL,
  `contacts` varchar(50) DEFAULT NULL,
  `account_number` varchar(36) NOT NULL,
  `nib` varchar(36) NOT NULL,
  `iban` varchar(36) DEFAULT NULL,
  `swift` varchar(36) DEFAULT NULL,
  `main_account` tinyint(1) NOT NULL,
  `comments` text,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_fiscal_years`
--

DROP TABLE IF EXISTS `accounts_fiscal_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_fiscal_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `balance` decimal(11,2) NOT NULL DEFAULT '0.00',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ENTITY` (`account_id`),
  KEY `FRACTION` (`fiscal_year_id`),
  CONSTRAINT `accounts_fiscal_years_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accounts_fiscal_years_ibfk_2` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `functions` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `ENTITY` (`entity_id`),
  KEY `FISCALYEAR` (`fiscal_year_id`),
  CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `administrators_ibfk_2` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `administrators_ibfk_3` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(20) NOT NULL,
  `foreign_key` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `dir` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `budget_statuses`
--

DROP TABLE IF EXISTS `budget_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `budget_types`
--

DROP TABLE IF EXISTS `budget_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `budget_type_id` int(11) NOT NULL,
  `budget_status_id` int(11) NOT NULL DEFAULT '1',
  `title` varchar(40) NOT NULL,
  `budget_date` date NOT NULL,
  `requested_amount` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `common_reserve_fund` decimal(5,2) NOT NULL DEFAULT '0.00',
  `begin_date` date NOT NULL,
  `shares` smallint(6) NOT NULL,
  `share_periodicity_id` int(11) NOT NULL,
  `share_distribution_id` int(11) NOT NULL,
  `due_days` smallint(6) NOT NULL,
  `meeting_draft` varchar(100) DEFAULT NULL,
  `comments` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `FISCALYEAR` (`fiscal_year_id`),
  KEY `BUDGETYPE` (`budget_type_id`),
  KEY `BUDGETSTATUS` (`budget_status_id`),
  KEY `SHAREPERIODICITY` (`share_periodicity_id`),
  KEY `SHAREDISTRIBUTION` (`share_distribution_id`),
  CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `budgets_ibfk_3` FOREIGN KEY (`budget_type_id`) REFERENCES `budget_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `budgets_ibfk_4` FOREIGN KEY (`budget_status_id`) REFERENCES `budget_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `budgets_ibfk_5` FOREIGN KEY (`share_periodicity_id`) REFERENCES `share_periodicities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `budgets_ibfk_6` FOREIGN KEY (`share_distribution_id`) REFERENCES `share_distributions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foreign_model` varchar(100) NOT NULL,
  `foreign_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `author_ip` varchar(20) DEFAULT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `author_website` varchar(200) DEFAULT NULL,
  `content` text NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_comments_foreign_data` (`foreign_id`,`foreign_model`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `condos`
--

DROP TABLE IF EXISTS `condos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `condos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `taxpayer_number` varchar(9) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `land_registry_year` int(11) DEFAULT NULL,
  `comments` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `matrix_registration` varchar(45) DEFAULT NULL,
  `land_registry` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drafts`
--

DROP TABLE IF EXISTS `drafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drafts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `content_model` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `vat_number` varchar(9) DEFAULT NULL,
  `representative` varchar(50) DEFAULT NULL,
  `address` text,
  `contacts` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `nib` varchar(24) DEFAULT NULL,
  `comments` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ENTITYTYPE` (`entity_type_id`),
  CONSTRAINT `entities_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities_fractions`
--

DROP TABLE IF EXISTS `entities_fractions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities_fractions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL,
  `fraction_id` int(11) NOT NULL,
  `owner_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ENTITY` (`entity_id`),
  KEY `FRACTION` (`fraction_id`),
  CONSTRAINT `entities_fractions_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `entities_fractions_ibfk_2` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entity_types`
--

DROP TABLE IF EXISTS `entity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fiscal_years`
--

DROP TABLE IF EXISTS `fiscal_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiscal_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `open_date` date NOT NULL,
  `close_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `CondoID` (`condo_id`),
  CONSTRAINT `fiscal_years_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fraction_types`
--

DROP TABLE IF EXISTS `fraction_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fraction_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fractions`
--

DROP TABLE IF EXISTS `fractions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fractions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `fraction` varchar(10) NOT NULL,
  `fraction_type_id` int(11) NOT NULL DEFAULT '1',
  `floor_location` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `mil_rate` decimal(6,2) DEFAULT NULL,
  `comments` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `MANAGER` (`manager_id`),
  KEY `CONDO` (`condo_id`),
  KEY `fk_fractions_1_idx` (`fraction_type_id`),
  CONSTRAINT `fk_fractions_1` FOREIGN KEY (`fraction_type_id`) REFERENCES `fraction_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fractions_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fractions_ibfk_2` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `insurance_types`
--

DROP TABLE IF EXISTS `insurance_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurance_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `insurances`
--

DROP TABLE IF EXISTS `insurances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) DEFAULT NULL,
  `fraction_id` int(11) DEFAULT NULL,
  `expiration_date` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `insurance_company` varchar(50) DEFAULT NULL,
  `policy` varchar(20) DEFAULT NULL,
  `insurance_type_id` int(11) NOT NULL,
  `insurance_amount` decimal(10,2) NOT NULL,
  `insurance_premium` decimal(10,2) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `FRACTION` (`fraction_id`),
  KEY `INSURANCETYPE` (`insurance_type_id`),
  CONSTRAINT `insurances_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `insurances_ibfk_2` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `insurances_ibfk_3` FOREIGN KEY (`insurance_type_id`) REFERENCES `insurance_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice_conference_statuses`
--

DROP TABLE IF EXISTS `invoice_conference_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_conference_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice_conferences`
--

DROP TABLE IF EXISTS `invoice_conferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_conferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `document` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `document_date` date NOT NULL,
  `payment_due_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `invoice_conference_status_id` int(11) NOT NULL,
  `comments` text,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `condo_id` (`condo_id`),
  KEY `fiscal_year_id` (`fiscal_year_id`),
  KEY `invoice_conference_status_id` (`invoice_conference_status_id`),
  KEY `entity_id` (`supplier_id`),
  CONSTRAINT `invoice_conferences_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_conferences_ibfk_2` FOREIGN KEY (`invoice_conference_status_id`) REFERENCES `invoice_conference_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `invoice_conferences_ibfk_3` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_conferences_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `maintenances`
--

DROP TABLE IF EXISTS `maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintenances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `client_number` varchar(20) DEFAULT NULL,
  `contract_number` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `last_inspection` date DEFAULT NULL,
  `next_inspection` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `comments` text,
  `active` tinyint(1) DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `SUPPLIER` (`supplier_id`),
  CONSTRAINT `maintenances_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `maintenances_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movement_categories`
--

DROP TABLE IF EXISTS `movement_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movement_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movement_operations`
--

DROP TABLE IF EXISTS `movement_operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movement_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movement_types`
--

DROP TABLE IF EXISTS `movement_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movement_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movements`
--

DROP TABLE IF EXISTS `movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movement_type_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `movement_date` date NOT NULL,
  `description` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `movement_category_id` int(11) NOT NULL,
  `movement_operation_id` int(11) NOT NULL,
  `document` varchar(20) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `MOVEMENTTYPE` (`movement_type_id`),
  KEY `ACCOUNT` (`account_id`),
  KEY `FISCALYEAR` (`fiscal_year_id`),
  KEY `MOVEMENTCATEGORY` (`movement_category_id`),
  KEY `MOVEMENTOPERATION` (`movement_operation_id`),
  CONSTRAINT `movements_ibfk_1` FOREIGN KEY (`movement_type_id`) REFERENCES `movement_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `movements_ibfk_3` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `movements_ibfk_4` FOREIGN KEY (`movement_category_id`) REFERENCES `movement_categories` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `movements_ibfk_5` FOREIGN KEY (`movement_operation_id`) REFERENCES `movement_operations` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `movements_ibfk_6` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `note_statuses`
--

DROP TABLE IF EXISTS `note_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `note_types`
--

DROP TABLE IF EXISTS `note_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_type_id` int(11) NOT NULL,
  `document` varchar(25) DEFAULT NULL,
  `fraction_id` int(11) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `budget_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pending_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `title` varchar(100) NOT NULL,
  `document_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `note_status_id` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NOTETYPE` (`note_type_id`),
  KEY `FRACTION` (`fraction_id`),
  KEY `ENTITY` (`entity_id`),
  KEY `FISCALYEAR` (`fiscal_year_id`),
  KEY `BUDGET` (`budget_id`),
  KEY `NOTESTATUS` (`note_status_id`),
  KEY `RECEIPT` (`receipt_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`note_type_id`) REFERENCES `note_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`fiscal_year_id`) REFERENCES `fiscal_years` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_5` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_6` FOREIGN KEY (`note_status_id`) REFERENCES `note_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `notes_ibfk_7` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foreign_model` varchar(100) NOT NULL,
  `foreign_id` int(11) NOT NULL,
  `author_ip` varchar(20) DEFAULT NULL,
  `rating` float NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_ratings_foreign_data` (`foreign_id`,`foreign_model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `receipt_counters`
--

DROP TABLE IF EXISTS `receipt_counters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipt_counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `counter` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CondoID` (`condo_id`),
  CONSTRAINT `receipt_counters_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `receipt_notes`
--

DROP TABLE IF EXISTS `receipt_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipt_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_type_id` int(11) NOT NULL,
  `document` varchar(25) DEFAULT NULL,
  `fraction_id` int(11) NOT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `budget_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pending_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `title` varchar(100) NOT NULL,
  `document_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `note_status_id` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NOTETYPE` (`note_type_id`),
  KEY `FRACTION` (`fraction_id`),
  KEY `ENTITY` (`entity_id`),
  KEY `FISCALYEAR` (`fiscal_year_id`),
  KEY `BUDGET` (`budget_id`),
  KEY `NOTESTATUS` (`note_status_id`),
  KEY `RECEIPT` (`receipt_id`),
  CONSTRAINT `receipt_notes_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `receipt_payment_types`
--

DROP TABLE IF EXISTS `receipt_payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipt_payment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `receipt_statuses`
--

DROP TABLE IF EXISTS `receipt_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipt_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(25) DEFAULT NULL,
  `document_date` date NOT NULL,
  `receipt_status_id` int(11) NOT NULL,
  `payment_user_id` int(11) DEFAULT NULL,
  `receipt_payment_type_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `condo_id` int(11) NOT NULL,
  `fraction_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `address` text,
  `observations` text,
  `cancel_user_id` int(11) DEFAULT NULL,
  `cancel_motive` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `CLIENT` (`client_id`),
  KEY `RECEIPTSTATUS` (`receipt_status_id`),
  KEY `PaymentUser` (`payment_user_id`),
  KEY `PaymentType` (`receipt_payment_type_id`),
  KEY `FRACTION` (`fraction_id`),
  KEY `CancelUser` (`cancel_user_id`),
  CONSTRAINT `fk_receipts_1` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_3` FOREIGN KEY (`receipt_status_id`) REFERENCES `receipt_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_4` FOREIGN KEY (`receipt_payment_type_id`) REFERENCES `receipt_payment_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_5` FOREIGN KEY (`payment_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `receipts_ibfk_6` FOREIGN KEY (`cancel_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `share_distributions`
--

DROP TABLE IF EXISTS `share_distributions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `share_distributions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `share_periodicities`
--

DROP TABLE IF EXISTS `share_periodicities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `share_periodicities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support`
--

DROP TABLE IF EXISTS `support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condo_id` int(11) NOT NULL,
  `fraction_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `description` text,
  `notes` text,
  `support_category_id` int(11) NOT NULL,
  `support_priority_id` int(11) NOT NULL,
  `support_status_id` int(11) NOT NULL,
  `assigned_user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_support_1_idx` (`support_category_id`),
  KEY `fk_support_2_idx` (`support_priority_id`),
  KEY `fk_support_3_idx` (`support_status_id`),
  KEY `fk_support_4_idx` (`condo_id`),
  KEY `fk_support_5_idx` (`fraction_id`),
  KEY `fk_support_6_idx` (`client_id`),
  KEY `fk_support_7_idx` (`assigned_user_id`),
  CONSTRAINT `fk_support_1` FOREIGN KEY (`support_category_id`) REFERENCES `support_categories` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_2` FOREIGN KEY (`support_priority_id`) REFERENCES `support_priorities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_3` FOREIGN KEY (`support_status_id`) REFERENCES `support_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_4` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_5` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_6` FOREIGN KEY (`client_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_support_7` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support_categories`
--

DROP TABLE IF EXISTS `support_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support_priorities`
--

DROP TABLE IF EXISTS `support_priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `support_statuses`
--

DROP TABLE IF EXISTS `support_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-13 22:25:47